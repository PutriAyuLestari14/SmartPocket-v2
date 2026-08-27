<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperatorPeminjamanController extends Controller
{
    public function index()
    {
        return view('operator.peminjaman.index');
    }

    public function create()
    {
        return view('operator.peminjaman.create');
    }

    public function store()
    {

    }

    public function pembayaranIndex()
    {

    }

    public function storePembayaran()
    {

    }


}
