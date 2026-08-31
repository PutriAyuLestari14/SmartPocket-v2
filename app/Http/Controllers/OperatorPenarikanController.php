<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperatorPenarikanController extends Controller
{
    public function create()
    {
        return view('operator.penarikan.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('operator.dashboard')->with('success', 'Penarikan berhasil!');
    }
}