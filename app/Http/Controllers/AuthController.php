<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        // kita ambil data user lalu simpan pada variable $user
        $user = Auth::user();

        // kondisi jika user nya ada
        if ($user) {
            // jika user nya memiliki level admin
            if ($user->level_id == '1')
            {
                return redirect()->intended('admin');
            }
            // jika user nya memiliki level manager
            else if ($user->level_id == '2')
            {
                return redirect()->intended('manager');
            }
        }
        return view('login');
    }

    public function proses_login(Request $request)
    {
        // buat validasi pada saat tombol login di klik
        // validasi nya username dan password wajib diisi
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // ambil data request username dan password saja
        $credential = $request->only('username', 'password');
        // cek jika data username dan password valid sesuai dengan data
        if (Auth::attempt($credential)) {

            // kalau berhasil simpan data user ya di variabel $user
            $user = Auth::user();

            // cek lagi jika level user admin maka arahkan halaman ke admin
            if ($user->level_id == '1') {
                return redirect()->intended('admin');
            }
            // jika level user nya user biasa maka arahkan ke halaman user
            elseif ($user->level_id == '2') {
                return redirect()->intended('manager');
            }
            // jika belum ada role maka ke halaman /
            return redirect()->intended('/');
        }
        // jika ada data user yang tidak valid maka kembalikan lagi ke halaman login
        // pastikan kirim pesan error juga kalau login gagal
        return redirect('login')
            ->withInput()
            ->withErrors(['login_gagal' => 'Pastikan kembali username dan password yang anda masukkan sudah benar']);
    }

    public function register()
    {
        //tampikan view register
        return view('register');
    }

    // aksi form register
    public function proses_register(Request $request)
    {
        // buat validasi proses register
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'username' => 'required|unique:m_user',
            'password' => 'required'
        ]);

        // kalau gagal kembali ke halaman register dengan munculkan pesan error
        if ($validator->fails()) {
            return redirect('/register')
            ->withErrors($validator)
            ->withInput();
        }

        // kalau berhasil isi level dan hash passwordnya ya biar secure
        
        $request['level_id'] = '2';
        $request['password'] = Hash::make($request->password);

        // masukkan semua data pada request ke table user
        UserModel::create($request->all());

        // kalau berhasil arahkan ke halaman login
        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        // logout itu harus menghapus session
        $request->session()->flush();

        // jalankan fungsi logout pada auth
        Auth::logout();

        // kembali ke halaman login
        return redirect('login');
    }
}
