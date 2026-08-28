<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperatorVerifikasiController extends Controller
{
    public function index()
    {
        return view('operator.verifikasi.index');
    }
}