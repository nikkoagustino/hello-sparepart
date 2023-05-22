<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbsensiModel;
use App\Models\SalesModel;

class AbsensiController extends Controller
{
    public function insertAbsen(Request $request) {
        $request->validate([
            'sales_code' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required|string',
            'type' => 'required|in:in,out',
        ]);

        if (AbsensiModel::addAbsen($request)) {
            return redirect('admin/account/absen')->withSuccess('Berhasil input absen');
        } else {
            return back()->withErrors('Gagal input absen');
        }
    }

    public function getAbsen() {
        $data = [
            'sales' => SalesModel::getAll(),
            'absen' => AbsensiModel::getAll(),
        ];
        return view('admin/account/absen')->with($data);
    }
}
