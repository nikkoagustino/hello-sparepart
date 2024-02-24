<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class VBeltModel extends Model
{
    use HasFactory;

    static function insert($request) {
        $insert = DB::table('tb_vbelt')
                    ->insert($request);
        return $insert;
    }

    static function getAll() {
        $result = DB::table('tb_vbelt')->get();
        return $result;
    }

    static function getById($id) {
        $result = DB::table('tb_vbelt')
                    ->where('id', $id)
                    ->first();
        return $result;
    }

    static function deleteVBelt($id) {
        $delete = DB::table('tb_vbelt')
                    ->where('id', $id)
                    ->delete();
        return $delete;
    }

    static function editVBelt($request) {
        $update = DB::table('tb_vbelt')
                    ->where('id', $request->id)
                    ->update([
                        'type_code' => $request->type_code,
                        'model' => $request->model,
                        'size_min' => $request->size_min,
                        'size_max' => $request->size_max,
                        'price' => $request->price,
                        'price_unit' => $request->price_unit,
                        'discount' => $request->discount,
                    ]);
        return $update;
    }

    static function searchVBelt($request) {
        $query = DB::table('tb_vbelt');
        if ($request->type_code) $query->where('type_code', 'like', '%'.$request->type_code.'%');
        if ($request->model) $query->where('model', 'like', '%'.$request->model.'%');
        return $query->get();
    }
}
