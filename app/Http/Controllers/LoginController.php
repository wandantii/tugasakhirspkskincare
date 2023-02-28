<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Alternatif;
use App\Models\Kategoriproduk;
use App\Models\Kriteria;
use App\Models\Nilaikriteria;
use App\Models\Produk;
use App\Models\Review;
use App\Models\Subkriteria;
use App\Models\User;
use App\Models\ViewAlternatifs;
use App\Models\ViewBrands;
use App\Models\ViewKriterias;
use App\Models\ViewNilais;
use App\Models\ViewProduks;
use App\Models\ViewReviews;
use App\Models\ViewUsers;


class LoginController extends Controller
{
  /* FRONT */
  /* Display a listing of the resource */
  public function index() {
    if(isset(auth()->user()->id_user)) {
      return redirect('/');
    } else {
      return view('front.auth.login');
    }
  }

  /* Autentikasi login untuk user */
  public function authenticate(Request $request) {
    $credentials = $request->validate([
      'username' => 'required',
      'password' => 'required'
    ]);
    if(Auth::attempt($credentials)) {
      $request->session()->regenerate();
      session()->put('username', $request->username);
      return redirect()->intended('/');
    }
    return back()->with('error', 'Login gagal! Periksa kembali username dan password anda.');
  }

  /* Logout untuk user */
  public function logout() {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('login');
  }



  /* ADMIN */
  /* Display a listing of the resource */
  public function indexadmin() {
    if(isset(auth()->user()->id_user)) {
      return redirect('admin');
    } else {
      return view('admin.auth.login');
    }
  }

  /* Autentikasi login untuk admin */
  public function authenticateadmin(Request $request) {
    $data = User::where('username', $request->username)->get('level');
    foreach($data as $data) {
      if($data->level == 'Admin') {
        $credentials = $request->validate([
          'username' => 'required',
          'password' => 'required'
        ]);
        if(Auth::attempt($credentials)) {
          $request->session()->regenerate();
          session()->put('username', $request->username);
          return redirect('admin')->with('success', 'Login berhasil! Hai, selamat datang admin.');
        }
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    }
    return redirect('admin/login')->with('error', 'Login gagal! Periksa kembali username dan password anda.');
  }

  /* Logout untuk admin */
  public function logoutadmin() {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('admin/login');
  }
}
