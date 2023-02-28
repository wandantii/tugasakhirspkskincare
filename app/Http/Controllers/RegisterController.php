<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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


class RegisterController extends Controller
{
  /* FRONT */
  /* Display a listing of the resource */
  public function index() {
    if(isset(auth()->user()->id_user)) {
      return redirect('/');
    } else {
      return view('front.auth.register');
    }
  }

  /* Store a newly created resource in storage untuk user*/
  public function store(Request $request) {
    $validatedData = $request->validate([
      'email' => 'required|email:dns|unique:tbl_user',
      'username' => ['required','min:3','max:225','unique:tbl_user'],
      'namalengkap' => 'required|min:5|max:225',
      'password' => 'required|min:5|max:25'
    ]);
    // $validatedData['password'] = bcrypt($validatedData['password']);
    $validatedData['password'] = Hash::make($validatedData['password']);
    // User::create($validatedData);
    User::create([
      'email' => $request->email,
      'username' => $request->username,
      'namalengkap' => $request->namalengkap,
      'password' => Hash::make($request->password),
      'level' => 'User'
    ]);
    // $request->session()->flash('success','Registration successfull! Please login.');
    return redirect('login')->with('success','Registrasi berhasil, silahkan login.');
  }



  /* ADMIN */
  /* Display a listing of the resource */
  public function indexadmin() {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        return view('admin.auth.register');
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Store a newly created resource in storage untuk admin*/
  public function storeadmin(Request $request) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $validatedData = $request->validate([
          'email' => 'required|email:dns|unique:tbl_user',
          'username' => ['required','min:3','max:225','unique:tbl_user'],
          'namalengkap' => 'required|min:5|max:225',
          'password' => 'required|min:5|max:225'
        ]);
        // $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['password'] = Hash::make($validatedData['password']);
        // User::create($validatedData);
        User::create([
          'email' => $request->email,
          'username' => $request->username,
          'namalengkap' => $request->namalengkap,
          'password' => Hash::make($request->password),
          'level' => 'Admin'
        ]);
        // $request->session()->flash('success','Registration successfull! Please login.');
        return redirect('admin/register')->with('success','Registrasi admin baru berhasil, silahkan login.');
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }
}
