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


class NilaikriteriaController extends Controller
{
  /* Display a listing of the resource */
  public function index() {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = ViewNilais::orderBy('created_at', 'desc')->get();
        return view('admin.nilaikriteria.index', compact(
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
        $data = new Nilaikriteria;
        $kriterias = Kriteria::all();
        return view('admin.nilaikriteria.create', compact(
          'data', 'kriterias'
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
          'nilai' => 'required|min:1|max:225'
        ]);
        /* input data */
        $data = new Nilaikriteria;
        $data->id_kriteria = $request->id_kriteria;
        $data->nama = $request->nama;
        $data->nilai = $request->nilai;
        $data->save();
        return redirect('admin/nilaikriteria')->with('success','Berhasil menambah data.');
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Display the specified resource */
  public function show($id_nilai) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = Nilaikriteria::find($id_nilai);
        return view('admin.nilaikriteria.show', compact(
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
  public function edit($id_nilai) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = Nilaikriteria::find($id_nilai);
        $kriterias = Kriteria::all();
        return view('admin.nilaikriteria.edit', compact(
          'data', 'kriterias'
        ));
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Update the specified resource in storage */
  public function update(Request $request, $id_nilai) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        /* validasi data */
        $validatedData = $request->validate([
          'nama' => 'required|min:3|max:225',
          'nilai' => 'required|min:1|max:225'
        ]);
        /* input data */
        $data = Nilaikriteria::find($id_nilai);
        $data->id_kriteria = $request->id_kriteria;
        $data->nama = $request->nama;
        $data->nilai = $request->nilai;
        $data->save();
        return redirect('admin/nilaikriteria')->with('success','Berhasil mengubah data.');
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Remove the specified resource from storage */
  public function destroy($id_nilai) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = Nilaikriteria::find($id_nilai);
        $carinilai = Alternatif::where('id_nilai',$id_nilai)->get();
        $countnilai = $carinilai->count();
        if($countnilai == 0) {
          $data->delete();
          return redirect('admin/nilaikriteria')->with('success','Berhasil menghapus data.');
        } else {
          return redirect('admin/nilaikriteria')->with('error','Gagal menghapus data! Terdapat '.$countnilai.' alternatif yang berisi nilai ini. Mohon hapus semua data alternatif yang bersangkutan dengan nilai ini terlebih dahulu.');
        }
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }
}
