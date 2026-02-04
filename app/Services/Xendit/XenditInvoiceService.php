<?php

namespace App\Services\Xendit;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class XenditInvoiceService
{
    public function createInvoice(array $payload): array
    {
        return $this->request()
            ->post($this->baseUrl().'/v2/invoices', $payload)
            ->throw()
            ->json();
    }

    protected function request(): PendingRequest
    {
        $secretKey = (string) config('xendit.secret_key');
        if ($secretKey === '') {
            throw new \RuntimeException('XENDIT_SECRET_KEY is not set.');
        }

        $request = Http::withBasicAuth($secretKey, '')
            ->acceptJson()
            ->asJson();

        if (! (bool) config('xendit.verify_ssl', true)) {
            $request = $request->withoutVerifying();
        }

        return $request;
    }

    protected function baseUrl(): string
    {
        return rtrim((string) config('xendit.invoice.base_url'), '/');
    }
}
