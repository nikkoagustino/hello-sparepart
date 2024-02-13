<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hash;
use DB;
use Session;

class AccountModel extends Model
{
    use HasFactory;

    static function getAll() {
        $result = DB::table('tb_account')->get();
        return $result;
    }

    static function getFromID($id) {
        $result = DB::table('tb_account')
                    ->where('id', $id)
                    ->first();
        return $result;
    }

    static function getFromUsername($username) {
        $result = DB::table('tb_account')
                    ->where('username', $username)
                    ->first();
        return $result;
    }

    static function insert($request) {
        $insert = DB::table('tb_account')
                    ->insert([
                        'fullname' => $request->fullname,
                        'username' => $request->username,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'master_pin' => $request->master_pin,
                    ]);
        return $insert;
    }

    static function editAdmin($request) {
        $update_arrays = [
            'fullname' => $request->fullname,
            'username' => $request->username,
        ];
        if ($request->password) {
            $update_arrays['password'] = Hash::make($request->password);
        }
        if ($request->master_pin) {
            $update_arrays['master_pin'] = $request->master_pin;
        }

        $update = DB::table('tb_account')
                    ->where('id', $request->id)
                    ->update($update_arrays);
        return $update;
    }

    static function save2FASecret($secret_key) {
        $update = DB::table('tb_account')
                    ->where('username', Session::get('userdata')->username)
                    ->update([
                        'two_fa_secret' => $secret_key
                    ]);
        return $update;
    }

    static function remove2FA() {
        $delete = DB::table('tb_account')
                    ->where('username', Session::get('userdata')->username)
                    ->update([
                        'two_fa_secret' => null
                    ]);
        return $delete;
    }

    static function deleteAdmin($username) {
        $delete = DB::table('tb_account')
                    ->where('username', $username)
                    ->delete();
        return $delete;
    }
}
