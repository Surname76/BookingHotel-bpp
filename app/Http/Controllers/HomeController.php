<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'Semua');
        if ($filter === 'Semua') {
            $rooms = Room::where('is_available', true)->get();
        } else {
            $rooms = Room::where('is_available', true)
                ->where('district', $filter)
                ->get();
        }
        return view('livewire.Pages.home', compact('rooms', 'filter'));
    }
}
