<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountModel;
use Hash;
use Session;

class AccountController extends Controller
{
    public function createAccount(Request $request) {
        $request->validate([
            'username' => 'required|string|min:6',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8',
            'email' => 'required|email',
        ]);

        if ($request->password != $request->confirm_password) {
            return redirect()->back()->withErrors('Konfirmasi Password Tidak Cocok');
        }

        if (AccountModel::insert($request)) {
            return redirect('admin/account/admin')->withSuccess('Akun Berhasil Dibuat');
        }
    }

    public function showAccount() {
        $data = [
            'accounts' => AccountModel::getAll(),
        ];
        return view('admin.account.admin')->with($data);
    }

    public function formLogin() {
        return view('admin.login');
    }

    public function logout() {
        Session::flush();
        return redirect('admin/login');
    }

    public function submitLogin(Request $request) {
        $request->validate([
            'username' => 'required|string|min:6',
            'password' => 'required|string|min:8',
        ]);

        $userdata = AccountModel::getFromUsername($request->username);
        if (!$userdata) {
            return redirect()->back()->withErrors('Username Tidak Ditemukan');
        }

        if (Hash::check($request->password, $userdata->password)) {
            Session::put('userdata', $userdata);
            return redirect('admin/dashboard');
        } else {
            return redirect()->back()->withErrors('Password Tidak Cocok');
        }
    }

    public function verifyPIN(Request $request) {
        $userdata = AccountModel::getFromUsername($request->username);
        if ($request->pin == $userdata->master_pin) {
            return response()->json([
                'success' => true,
                'message' => 'PIN valid',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'PIN invalid',
            ], 403);
        }
    }
}
