<?php

namespace App\Http\Controllers;

class TabunganController extends Controller
{
    public function index()
    {
        $nasabah = auth()->user()->nasabah()->with('rekening')->first();

        return view('nasabah.dashboard', [
            'nasabah' => $nasabah,
            'saldo'   => $nasabah?->rekening?->saldo ?? 0,
        ]);
    }
}