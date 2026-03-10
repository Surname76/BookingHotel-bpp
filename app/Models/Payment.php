<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Payment extends Model
    {
        use HasFactory;

        protected $fillable = [
            'booking_request_id',
            'user_id',
            'provider',
            'external_id',
            'provider_reference',
            'invoice_url',
            'currency',
            'amount',
            'status',
            'metadata',
            'paid_at',
            'expires_at',
        ];

        protected $casts = [
            'amount' => 'decimal:2',
            'metadata' => 'array',
            'paid_at' => 'datetime',
            'expires_at' => 'datetime',
        ];

        public function bookingRequest()
        {
            return $this->belongsTo(BookingRequest::class);
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }
    }

