<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class XenditWebhookController extends Controller
{
    public function invoices(Request $request): Response
    {
        $expectedToken = (string) config('xendit.callback_token');
        $providedToken = (string) $request->header('x-callback-token');

        if ($expectedToken !== '' && $providedToken !== $expectedToken) {
            return response('Invalid callback token', 401);
        }

        $payload = $request->json()->all();

        $invoiceId = $payload['id'] ?? null;
        $externalId = $payload['external_id'] ?? null;
        $status = strtoupper((string) ($payload['status'] ?? ''));

        if (! $invoiceId && ! $externalId) {
            return response('Missing invoice identifier', 422);
        }

        DB::transaction(function () use ($invoiceId, $externalId, $status, $payload) {
            $paymentQuery = Payment::query()->lockForUpdate();

            $payment = $paymentQuery
                ->when($invoiceId, fn ($q) => $q->where('provider_reference', $invoiceId))
                ->when(! $invoiceId && $externalId, fn ($q) => $q->where('external_id', $externalId))
                ->first();

            if (! $payment) {
                return;
            }

            if ($invoiceId && ! $payment->provider_reference) {
                $payment->provider_reference = $invoiceId;
            }

            if (($payload['invoice_url'] ?? null) && ! $payment->invoice_url) {
                $payment->invoice_url = $payload['invoice_url'];
            }

            if (in_array($status, ['PAID', 'SETTLED'], true)) {
                $payment->status = 'paid';
                $payment->paid_at = isset($payload['paid_at']) ? Carbon::parse($payload['paid_at']) : now();
            } elseif ($status === 'EXPIRED') {
                $payment->status = 'expired';
            } elseif ($status === 'FAILED') {
                $payment->status = 'failed';
            }

            $payment->metadata = array_merge($payment->metadata ?? [], [
                'xendit_webhook' => $payload,
            ]);

            $payment->save();

            if ($payment->status !== 'paid') {
                return;
            }

            $bookingRequest = $payment->bookingRequest()
                ->with(['room'])
                ->first();

            if (! $bookingRequest) {
                return;
            }

            if ($bookingRequest->cancelled_at) {
                return;
            }

            $existingBooking = Booking::query()
                ->where('booking_request_id', $bookingRequest->id)
                ->first();

            if ($existingBooking) {
                return;
            }

            $checkIn = Carbon::parse($bookingRequest->check_in);
            $checkOut = Carbon::parse($bookingRequest->check_out);

            $overlapExists = Booking::query()
                ->where('room_id', $bookingRequest->room_id)
                ->where('status', 'confirmed')
                ->whereDate('check_in', '<', $checkOut)
                ->whereDate('check_out', '>', $checkIn)
                ->exists();

            if ($overlapExists) {
                $bookingRequest->update([
                    'status' => 'rejected',
                    'note' => trim((string) $bookingRequest->note."\nTanggal bentrok saat pembayaran dikonfirmasi."),
                ]);

                $payment->update([
                    'status' => 'paid_conflict',
                ]);

                return;
            }

            $totalNights = max(1, $checkIn->diffInDays($checkOut));
            $pricePerNight = (float) $bookingRequest->room->price_per_night;
            $totalPrice = $totalNights * $pricePerNight;

            Booking::create([
                'user_id' => $bookingRequest->user_id,
                'booking_request_id' => $bookingRequest->id,
                'payment_id' => $payment->id,
                'room_id' => $bookingRequest->room_id,
                'guest_name' => $bookingRequest->guest_name,
                'guest_email' => $bookingRequest->guest_email,
                'guest_phone' => $bookingRequest->guest_phone,
                'check_in' => $checkIn,
                'check_in_time' => $bookingRequest->check_in_time,
                'check_out' => $checkOut,
                'check_out_time' => $bookingRequest->check_out_time,
                'price_per_night' => $pricePerNight,
                'total_nights' => $totalNights,
                'total_price' => $totalPrice,
                'status' => 'confirmed',
            ]);

            $bookingRequest->update([
                'status' => 'confirmed',
                'note' => trim((string) $bookingRequest->note."\nPaid via Xendit."),
            ]);
        });

        return response('OK', 200);
    }
}
