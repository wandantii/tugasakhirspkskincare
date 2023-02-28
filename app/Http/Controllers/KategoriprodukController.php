<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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


class KategoriprodukController extends Controller
{
  /* Display a listing of the resource */
  public function index() {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = Kategoriproduk::orderBy('created_at', 'desc')->get();
        return view('admin.kategoriproduk.index', compact(
          'data'
        ));
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Show the form for creating a new resource */
  public function create() {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = new Kategoriproduk;
        return view('admin.kategoriproduk.create', compact(
          'data'
        ));
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Store a newly created resource in storage */
  public function store(Request $request) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $validatedData = $request->validate([
          'nama' => 'required|min:3|max:225'
        ]);
        $data = new Kategoriproduk;
        $data->nama = $request->nama;
        $data->save();
        return redirect('admin/kategoriproduk')->with('success','Berhasil menambah data.');
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Display the specified resource */
  public function show($id_kategoriproduk) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = Kategoriproduk::find($id_kategoriproduk);
        return view('admin.kategoriproduk.show', compact(
          'data'
        ));
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }
  
  /* Show the form for editing the specified resource */
  public function edit($id_kategoriproduk) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = Kategoriproduk::find($id_kategoriproduk);
        return view('admin.kategoriproduk.edit', compact(
          'data'
        ));
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Update the specified resource in storage */
  public function update(Request $request, $id_kategoriproduk) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        if($request->nama != $request->oldnama) {
          $validatedData = $request->validate([
            'nama' => 'required|min:3|max:225|unique:tbl_kategoriproduk'
          ]);
        }
        $data = Kategoriproduk::find($id_kategoriproduk);
        $data->nama = $request->nama;
        $data->save();
        return redirect('admin/kategoriproduk')->with('success','Berhasil mengubah data.');
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Remove the specified resource from storage */
  public function destroy($id_kategoriproduk) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = Kategoriproduk::find($id_kategoriproduk);
        $data->delete();
        return redirect('admin/kategoriproduk')->with('success','Berhasil menghapus data.');
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }
}
