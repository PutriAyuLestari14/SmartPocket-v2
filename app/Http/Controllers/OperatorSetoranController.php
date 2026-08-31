<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperatorSetoranController extends Controller
{
    public function create()
    {
        return view('operator.setoran.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('operator.dashboard')->with('success', 'Setoran berhasil!');
    }
}