<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperatorLaporanController extends Controller
{
        public function index()
    {
        return view('operator.laporan.index');
    }
}
