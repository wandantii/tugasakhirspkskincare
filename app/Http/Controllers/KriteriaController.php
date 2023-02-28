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


class KriteriaController extends Controller
{
  /* Display a listing of the resource */
  public function index() {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = Kriteria::orderBy('created_at', 'desc')->get();
        return view('admin.kriteria.index', compact(
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
        $data = new Kriteria;
        return view('admin.kriteria.create', compact(
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
        /* validasi data */
        $validatedData = $request->validate([
          'nama' => 'required|min:3|max:225',
          'tipe' => 'required|min:1|max:225',
          'bobot' => 'required|min:1|max:225'
        ]);
        /* input data */
        $data = new Kriteria;
        $data->nama = $request->nama;
        $data->tipe = $request->tipe;
        $data->bobot = $request->bobot;
        $data->save();
        return redirect('admin/kriteria')->with('success','Berhasil menambah data.');
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Display the specified resource */
  public function show($id_kriteria) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = Kriteria::find($id_kriteria);
        return view('admin.kriteria.show', compact(
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
  public function edit($id_kriteria) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = Kriteria::find($id_kriteria);
        return view('admin.kriteria.edit', compact(
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
  public function update(Request $request, $id_kriteria) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        /* validasi data */
        $validatedData = $request->validate([
          'nama' => 'required|min:3|max:225',
          'tipe' => 'required|min:1|max:225',
          'bobot' => 'required|min:1|max:225'
        ]);
        /* input data */
        $data = Kriteria::find($id_kriteria);
        $data->nama = $request->nama;
        $data->tipe = $request->tipe;
        $data->bobot = $request->bobot;
        $data->save();
        return redirect('admin/kriteria')->with('success','Berhasil mengubah data.');
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }
  
  /* Remove the specified resource from storage */
  public function destroy($id_kriteria) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = Kriteria::find($id_kriteria);
        $data->delete();
        return redirect('admin/kriteria')->with('success','Berhasil menghapus data.');
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }
}
