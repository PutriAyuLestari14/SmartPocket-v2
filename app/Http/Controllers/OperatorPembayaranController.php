<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperatorPembayaranController extends Controller
{
    public function create()
    {
        return view('operator.pembayaran.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('operator.dashboard')->with('success', 'Pembayaran berhasil!');
    }
}