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

    public function getAbsen(Request $request) {
        $data = [
            'sales' => SalesModel::getAll(),
            'absen' => AbsensiModel::getAll($request),
        ];
        return view('admin/account/absen')->with($data);
    }

    public function printAbsensi(Request $request) {
        $data = [
            'absen' => AbsensiModel::getAll($request),
        ];
        $pdf = \PDF::loadView('admin/print/absensi', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
        // return view('admin/print/absensi')->with($data);
    }
}
