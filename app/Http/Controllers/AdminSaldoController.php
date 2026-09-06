<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSaldoController extends Controller
{
    public function index()
    {
        $nasabahs = Nasabah::with('rekening')
            ->orderBy('nama', 'desc')
            ->paginate(10);

        return view('admin.saldo.index', compact('nasabahs'));
    }

}