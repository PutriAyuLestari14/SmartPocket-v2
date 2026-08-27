<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;


class TransaksiController extends Controller
{

    public function index()
    {
        return view('operator.transaksi.index');
    }
    
    public function storeDeposit(Request $request) //setoran
    {

    }
    
    public function storeWithdrawal(Request $request) //penarikan
    {

    }
    
    public function history()
    {
        $transactions = Transaction::latest()->get(); // riwayat
        return view('transaksi.history', compact('transactions'));
    }
}