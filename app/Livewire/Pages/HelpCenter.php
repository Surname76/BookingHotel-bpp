<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class HelpCenter extends Component
{
    public $search = '';

    // Data FAQ (Bisa dipindah ke Database nantinya)
    protected $allFaqs = [
        ['q' => 'Bagaimana cara mengubah tanggal pemesanan?', 'a' => 'Anda dapat mengubah melalui menu Pesanan Saya maksimal 24 jam sebelum check-in.'],
        ['q' => 'Apakah bisa bayar di hotel?', 'a' => 'Beberapa mitra hotel kami mendukung fitur Bayar di Properti.'],
        ['q' => 'Metode pembayaran apa saja?', 'a' => 'Kami menerima Transfer Bank, E-Wallet (OVO, Dana), dan Kartu Kredit.'],
        ['q' => 'Cara membatalkan pesanan?', 'a' => 'Klik menu Pesanan Saya, pilih pesanan yang ingin dibatalkan, lalu klik tombol Batalkan.'],
    ];

    public function render()
    {
        // Memfilter FAQ secara real-time berdasarkan input search
      $faqs = collect($this->allFaqs)->filter(function($item) {
            return str_contains(strtolower($item['q']), strtolower($this->search));
        });

        return view('livewire.pages.help-center', [
            'faqs' => $faqs
        ]);
    }
}
