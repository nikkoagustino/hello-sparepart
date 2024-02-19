<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuratJalanController extends Controller
{
    public function showSuratJalanForm()
    {
        return view('admin/dashboard/surat-jalan');
    }
}
