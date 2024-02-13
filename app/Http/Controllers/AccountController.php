<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountModel;
use Hash;
use Session;
use OTPHP\TOTP;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AccountController extends Controller
{
    public function showAddAccountForm() {
        return view('admin/account/admin-add');
    }

    public function showAdminDetail(Request $request) {
        $data = [
            'admin' => AccountModel::getFromID($request->id)
        ];
        return view('admin/account/admin-detail')->with($data);
    }

    public function submitEditAdmin(Request $request) {
        $request->validate([
            'id' => 'required|exists:tb_account,id',
            'fullname' => 'required|string',
            'username' => 'required|string|min:6',
            'password' => 'nullable|string|min:8',
            'confirm_password' => 'nullable|string|min:8',
            'email' => 'nullable|email',
            'master_pin' => 'nullable|numeric',
        ]);

        if ($request->password) {
            if ($request->password !== $request->confirm_password) {
                return redirect()->back()->withErrors('Konfirmasi Password Tidak Cocok');
            }
        }

        if (AccountModel::editAdmin($request)) {
            return redirect('admin/account/admin')->withSuccess('Akun Berhasil Diubah');
        }
    }

    public function createAccount(Request $request) {
        $request->validate([
            'fullname' => 'required|string',
            'username' => 'required|string|min:6|unique:tb_account,username',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8',
            'email' => 'nullable|email',
            'master_pin' => 'required|numeric',
        ]);

        if ($request->password !== $request->confirm_password) {
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
            if (!$userdata->two_fa_secret) {
                return redirect('admin/account/2fa-setup');
            } else {
                return redirect('admin/login/otp');
            }
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

    public function show2FASetup() {
        $otp = TOTP::generate();
        $otp->setLabel('Turbo Express Motor - '.Session::get('userdata')->username);
        $otp->setParameter('image', url('assets/img/logo.png'));
        $secret_key = $otp->getSecret();

        $data = [
            'secret_key' => $secret_key,
            'qrcode' => QrCode::size(250)->generate($otp->getProvisioningUri()),
        ];
        return view('admin/account/2fa-setup')->with($data);
    }

    public function submit2FASetup(Request $request) {
        $request->validate([
            'secret_key' => 'required|string',
            'otp' => 'required|numeric',
        ]);

        $otp = TOTP::create($request->secret_key);
        $verify = $otp->verify($request->otp);
        if (!$verify) {
            return back()->withErrors('OTP Invalid');
        }

        if (AccountModel::save2FASecret($request->secret_key)) {
            return redirect('admin/dashboard')->withSuccess('2FA berhasil disetting');
        } else {
            return back()->withErrors('Gagal setting 2FA');
        }
    }

    public function showOTPForm() {
        return view('admin/otp');
    }

    public function verifyOTP(Request $request) {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $otp = TOTP::create(Session::get('userdata')->two_fa_secret);
        $verify = $otp->verify($request->otp);
        if (!$verify) {
            return back()->withErrors('OTP Invalid');
        }
        return redirect('admin/dashboard');
    }

    public function remove2FA() {
        if (AccountModel::remove2FA()) {
            return redirect('admin/logout')->withSuccess('Berhasil menghapus 2FA, silahkan login ulang dan setup 2FA baru.');
        }
    }

    public function deleteAdmin(Request $request) {
        if (AccountModel::deleteAdmin($request->username)) {
            return redirect('admin/account/admin')->withSuccess('Berhasil menghapus admin');
        } else {
            return redirect('admin/account/admin')->withErrors('Gagal menghapus admin');
        }
    }
}
