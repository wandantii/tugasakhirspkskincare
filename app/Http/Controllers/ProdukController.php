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


class ProdukController extends Controller
{
  /* FRONT */
  /* Display a listing of the resource */
  public function frontindex() {
    $kategoriproduks = Kategoriproduk::orderBy('created_at', 'desc')->get();
    $brands = ViewBrands::orderBy('merk')->get();
    $data = ViewProduks::orderBy('nama')->get();
    return view('front.produk.index', compact(
      'data', 'kategoriproduks', 'brands'
    ));
  }

  /* Display the specified resource */
  public function frontshow($id_produk) {
    if(isset(auth()->user()->id_user)) {
      $getiduser = auth()->user()->id_user;
      $user = ViewUsers::find($getiduser);
      $cekreview = ViewReviews::where('id_user',$getiduser)->where('id_produk',$id_produk)->count();
      $getreview = ViewReviews::where('id_user',$getiduser)->where('id_produk',$id_produk)->first();
    } else {
      $user = null;
      $cekreview = null;
      $getreview = null;
    }
    // echo $getreview;
    $data = ViewProduks::find($id_produk);
    $reviews = ViewReviews::where('id_produk', $id_produk)->orderBy('created_at','desc')->paginate(4);
    $tipekulits = ViewKriterias::where('id_kriteria', '2')->get();
    $jeniskelamins = ViewKriterias::where('id_kriteria', '3')->get();
    return view('front.produk.show', compact(
      'data', 'user', 'cekreview', 'getreview', 'reviews', 'jeniskelamins', 'tipekulits'
    ));
  }



  /* ADMIN */
  /* Display a listing of the resource */
  public function index() {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = ViewProduks::orderBy('created_at', 'desc')->get();
        return view('admin.produk.index', compact(
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
        $data = new Produk;
        $kategoriproduks = Kategoriproduk::orderBy('nama')->get();
        $tipekulits = ViewKriterias::where('id_kriteria', '2')->get();
        $jeniskelamins = ViewKriterias::where('id_kriteria', '3')->get();
        return view('admin.produk.create', compact(
          'data', 'kategoriproduks', 'jeniskelamins', 'tipekulits'
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
        /* join array komposisi berbahaya */
        if(!empty($request->input('komposisiberbahaya'))) {
          $komposisiberbahaya = join(',', $request->input('komposisiberbahaya'));
        } else {
          $komposisiberbahaya = '';
        }
        /* join array tipe kulit */
        if(!empty($request->input('tipekulit'))) {
          $tipekulit = join(',', $request->input('tipekulit'));
        } else {
          $tipekulit = '';
        }
        /* join array jenis kelamin */
        if(!empty($request->input('jeniskelamin'))) {
          $jeniskelamin = join(',', $request->input('jeniskelamin'));
        } else {
          $jeniskelamin = '';
        }
        /* jika ada gambar maka: */
        if($request->hasFile('gambar')){
          $path = $request->file('gambar')->store('gambarproduk');
        } else {
          $path = '';
        }
        /* validasi data */
        $validatedData = $request->validate([
          'id_kategoriproduk' => 'required|min:1|max:225',
          'nama' => 'required|min:3|max:225',
          'merk' => 'required|min:3|max:225',
          'harga' => 'required|numeric|min:1000',
          'netto' => 'required|min:3|max:225',
          'jeniskelamin' => 'required|min:1|max:225',
          'minimalusia' => 'required|numeric|min:10',
          'tipekulit' => 'required|min:1|max:225',
          'deskripsi' => 'required|min:3|max:1000',
          'gambar' => 'required|image|file|max:1024'
        ]);
        /* input data */
        // dd($request->all());
        $data = new Produk;
        $data->id_kategoriproduk = $request->id_kategoriproduk;
        $data->nama = $request->nama;
        $data->merk = $request->merk;
        $data->harga = $request->harga;
        $data->netto = $request->netto;
        $data->jeniskelamin = $jeniskelamin;
        $data->minimalusia = $request->minimalusia;
        $data->tipekulit = $tipekulit;
        $data->komposisiberbahaya = $komposisiberbahaya;
        $data->deskripsi = $request->deskripsi;
        $data->gambar = $path;
        $data->save();
        return redirect('admin/produk')->with('success','Berhasil menambah data.');
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Display the specified resource */
  public function show($id_produk) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = ViewProduks::find($id_produk);
        $tipekulits = ViewKriterias::where('id_kriteria', '2')->get();
        $jeniskelamins = ViewKriterias::where('id_kriteria', '3')->get();
        return view('admin.produk.show', compact(
          'data', 'jeniskelamins', 'tipekulits'
        ));
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Show the form for editing the specified resource */
  public function edit($id_produk) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = Produk::find($id_produk);
        $kategoriproduks = Kategoriproduk::orderBy('nama')->get();
        $tipekulits = ViewKriterias::where('id_kriteria', '2')->get();
        $jeniskelamins = ViewKriterias::where('id_kriteria', '3')->get();
        return view('admin.produk.edit', compact(
          'data', 'kategoriproduks', 'jeniskelamins', 'tipekulits'
        ));
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Update the specified resource in storage */
  public function update(Request $request, $id_produk) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        /* join array komposisi berbahaya */
        if(!empty($request->input('komposisiberbahaya'))) {
          $komposisiberbahaya = join(',', $request->input('komposisiberbahaya'));
        } else {
          $komposisiberbahaya = '';
        }
        /* join array tipe kulit */
        if(!empty($request->input('tipekulit'))) {
          $tipekulit = join(',', $request->input('tipekulit'));
        } else {
          $tipekulit = '';
        }
        /* join array jenis kelamin */
        if(!empty($request->input('jeniskelamin'))) {
          $jeniskelamin = join(',', $request->input('jeniskelamin'));
        } else {
          $jeniskelamin = '';
        }
        /* jika ada gambar maka: */
        if($request->hasFile('gambar')){
          $path = $request->file('gambar')->store('gambarproduk');
        } else {
          $path = $request->gambarcadangan;
        }
        /* validasi data */
        $validatedData = $request->validate([
          'id_kategoriproduk' => 'required|min:1|max:225',
          'nama' => 'required|min:3|max:225',
          'merk' => 'required|min:3|max:225',
          'harga' => 'required|min:3|max:225',
          'netto' => 'required|min:3|max:225',
          'jeniskelamin' => 'required|min:1|max:225',
          'minimalusia' => 'required|min:1|max:225',
          'tipekulit' => 'required|min:1|max:225',
          'deskripsi' => 'required|min:3|max:1000'
        ]);
        /* input data */
        // dd($request->all());
        $data = Produk::find($id_produk);
        $data->id_kategoriproduk = $request->id_kategoriproduk;
        $data->nama = $request->nama;
        $data->merk = $request->merk;
        $data->harga = $request->harga;
        $data->netto = $request->netto;
        $data->jeniskelamin = $jeniskelamin;
        $data->minimalusia = $request->minimalusia;
        $data->tipekulit = $tipekulit;
        $data->komposisiberbahaya = $komposisiberbahaya;
        $data->deskripsi = $request->deskripsi;
        $data->gambar = $path;
        $data->save();
        return redirect('admin/produk')->with('success','Berhasil mengubah data.');
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Remove the specified resource from storage */
  public function destroy($id_produk) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = Produk::find($id_produk);
        if(isset($data->alternatif)) {
          return redirect('admin/produk')->with('error','Gagal menghapus data! Harap hapus data alternatif produk ini terlebih dahulu.');
        } else {
          $data->delete();
          return redirect('admin/produk')->with('success','Berhasil menghapus data.');
        }
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }
}
