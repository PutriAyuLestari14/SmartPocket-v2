<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;

class AdminNasabahController extends Controller
{
    public function index()
    {
        $nasabahs = Nasabah::with(['user', 'rekening'])
                    ->join('rekening_tabungan', 'nasabah.id_nasabah', '=', 'rekening_tabungan.id_nasabah')
                    ->orderBy('rekening_tabungan.no_rek', 'asc')
                    ->select('nasabah.*')
                    ->get();
        return view('admin.nasabah.index', compact('nasabahs'));
    }
}