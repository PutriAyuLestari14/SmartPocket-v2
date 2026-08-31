<?php
namespace App\Http\Controllers;

class AdminLaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }
}