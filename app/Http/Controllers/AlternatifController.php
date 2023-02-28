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


class AlternatifController extends Controller
{
  /* Display a listing of the resource */
  public function index() {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = ViewAlternatifs::orderBy('created_at', 'desc')->get();
        return view('admin.alternatif.index', compact(
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
        $datas = new Alternatif;
        $produks = ViewProduks::where('alternatif','Done')->orderBy('merk')->get();
        $kategoriproduks = Kategoriproduk::all();
        $kriterias = Kriteria::all();
        $subkriterias = ViewKriterias::all();
        $nilais = Nilaikriteria::all();
        $subkriteriasCount = $subkriterias->count();
        return view('admin.alternatif.create', compact(
          'datas', 'produks', 'kategoriproduks', 'kriterias', 'subkriterias', 'nilais', 'subkriteriasCount'
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
          'id_produk' => 'required'
        ]);
        /* input data */
        $produks = ViewProduks::where('alternatif','Done')->orderBy('merk')->get();
        $kategoriproduks = Kategoriproduk::all();
        $kriterias = Kriteria::all();
        $subkriterias = Subkriteria::all();
        $nilais = Nilaikriteria::all();
        // $kriteriasCount = $kriterias->count();
        // $subkriteriasCount = $subkriterias->count();
        // echo $kriteriasCount.' '.$subkriteriasCount;
        foreach($kriterias as $kriteria) {
          $kriteriabersub = Subkriteria::where('id_kriteria', $kriteria->id_kriteria)->count();
          // echo $kriteriabersub;
          if($kriteriabersub > 0) {
            foreach($subkriterias as $subkriteria) {
              if($subkriteria->id_kriteria == $kriteria->id_kriteria) {
                $data = new Alternatif;
                $nilaisub = strval($subkriteria->id_subkriteria);
                $nilaisubasli = 'nilai'.$nilaisub;
                $data->id_kategoriproduk = $request->id_kategoriproduk;
                $data->id_produk = $request->id_produk;
                $data->id_kriteria = $subkriteria->id_kriteria;
                $data->id_subkriteria = $subkriteria->id_subkriteria;
                $data->id_nilai = $request->$nilaisubasli;
                $data->save();
                $getidproduk = Produk::find($request->id_produk);
                $getidproduk->alternatif = 'Done';
                $getidproduk->save();
              }
            }
          } else {
            $data = new Alternatif;
            $nilaikri = strval($kriteria->id_kriteria);
            $nilaikriasli = 'nilai'.$nilaikri;
            $data->id_kategoriproduk = $request->id_kategoriproduk;
            $data->id_produk = $request->id_produk;
            $data->id_kriteria = $kriteria->id_kriteria;
            $data->id_subkriteria = '';
            $data->id_nilai = $request->$nilaikriasli;
            $data->save();
            $getidproduk = Produk::find($request->id_produk);
            $getidproduk->alternatif = 'Done';
            $getidproduk->save();
          }
        }
        // dd($request->all());
        return redirect('admin/alternatif/');
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
        $alternatifs = Alternatif::all();
        $produks = ViewProduks::where('alternatif','Done')->orderBy('merk')->get();
        $kategoriproduks = Kategoriproduk::all();
        $kriterias = Kriteria::all();
        $subkriterias = ViewKriterias::all();
        $nilais = Nilaikriteria::all();
        $subkriteriasCount = $subkriterias->count();
        $dataproduk = ViewProduks::find($id_produk);
        $dataalternatif = Alternatif::where('id_produk', $id_produk)->get();
        $dataviewalternatifs = ViewAlternatifs::where('id_produk', $id_produk)->get();
        $kategoriproduks = Kategoriproduk::all();
        $tipekulits = ViewKriterias::where('id_kriteria', '2')->get();
        $jeniskelamins = ViewKriterias::where('id_kriteria', '3')->get();
        return view('admin.alternatif.show', compact(
          'dataproduk', 'dataalternatif', 'dataviewalternatifs', 'alternatifs', 'produks', 'kategoriproduks', 'kriterias', 'subkriterias', 'nilais', 'subkriteriasCount', 'jeniskelamins', 'tipekulits'
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
        $alternatifs = Alternatif::all();
        $produks = ViewProduks::where('alternatif','Done')->orderBy('merk')->get();
        $kriterias = Kriteria::all();
        $subkriterias = ViewKriterias::all();
        $nilais = Nilaikriteria::all();
        $subkriteriasCount = $subkriterias->count();
        $dataproduk = ViewProduks::find($id_produk);
        $dataalternatif = Alternatif::where('id_produk', $id_produk)->get();
        $dataviewalternatifs = ViewAlternatifs::where('id_produk', $id_produk)->get();
        $kategoriproduks = Kategoriproduk::all();
        $tipekulits = ViewKriterias::where('id_kriteria', '2')->get();
        $jeniskelamins = ViewKriterias::where('id_kriteria', '3')->get();
        return view('admin.alternatif.edit', compact(
          'dataproduk', 'dataalternatif', 'dataviewalternatifs', 'alternatifs', 'produks', 'kategoriproduks', 'kriterias', 'subkriterias', 'nilais', 'subkriteriasCount', 'jeniskelamins', 'tipekulits'
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
        $dataids = Alternatif::where('id_produk', $id_produk)->get();
        foreach($dataids as $dataid) {
          $idalternatif = $dataid->id_alternatif;
          $data = Alternatif::find($idalternatif);
          $nilaisub = strval($dataid->id_subkriteria);
          $nilaisubasli = 'nilai'.$nilaisub;
          $nilaikriteria = strval($dataid->id_kriteria);
          $nilaikriteriaasli = 'nilai'.$nilaikriteria;
          $data->id_kategoriproduk = $request->id_kategoriproduk;
          $data->id_produk = $request->id_produk;
          $data->id_kriteria = $dataid->id_kriteria;
          $data->id_subkriteria = $dataid->id_subkriteria;
          if($dataid->id_subkriteria == '') {
            $data->id_nilai = $request->$nilaikriteriaasli;
          } else {
            $data->id_nilai = $request->$nilaisubasli;
          }
          $data->save();
        }
        return redirect('admin/alternatif/');
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
        $dataids = Alternatif::where('id_produk', $id_produk)->get();
        foreach($dataids as $dataid) {
          $idalternatif = $dataid->id_alternatif;
          $data = Alternatif::find($idalternatif);
          $data->delete();
        }
        $dataproduk = Produk::find($id_produk);
        $dataproduk->alternatif = null;
        $dataproduk->save();
        return redirect('admin/alternatif/');
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Get produk berdasarkan kategori untuk modal */
  public function getprodukbykategori(Request $request) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $id_kategoriproduk = $request->id_kategoriproduk;
        // console.log($id_kategoriproduk);
        $produks = ViewProduks::where('id_kategoriproduk', $id_kategoriproduk)->where('alternatif', null)->orderBy('merk')->get();
        $countproduks = count($produks);
        $no = 1;
        if($countproduks > 0) {
          foreach($produks as $produk){
            echo "<tr class='table-tr' data-url='$produk->id_produk' style='cursor:pointer;'>
                    <td>".$no++.".</td>
                    <td>$produk->merk</td>
                    <td>$produk->nama</td>
                    <td>"; echo(number_format($produk->harga)); echo "</td>
                    <td>$produk->netto</td>
                  </tr>";
            // echo "<option value='$produk->id_produk'>$produk->nama</option>";
          }
        } else {
          echo "<tr>
                  <td colspan='5' style='text-align:center'>Tidak ada data yang ditemukan</td>
                </tr>";
        }
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }

  /* Get produk berdasarkan kategori untuk dipaste di halaman input */
  public function getprodukbykategorilagi(Request $request) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $id_produk = $request->id_produk;
        // console.log($id_produk);
        $kategoriproduks = Kategoriproduk::all();
        $tipekulits = ViewKriterias::where('id_kriteria', '2')->get();
        $jeniskelamins = ViewKriterias::where('id_kriteria', '3')->get();
        $produks = ViewProduks::where('id_produk', $id_produk)->get();
        foreach($produks as $produk){
          echo "
            <div class='row mt-5'>
              <div class='col-sm-6'>
                <div class='row'>
                  <div class='col-sm-6 mb-3'>
                    <label class='col-form-label'><b>Kategori Produk</b></label>
                    <input type='hidden' class='form-control' value='$produk->id_kategoriproduk' name='id_kategoriproduk' id='id_kategoriproduk' readonly>
                    <input type='text' class='form-control' value='$produk->kategoriproduk' name='kategoriproduk' id='kategoriproduk' readonly>
                  </div>
                  <div class='col-sm-6 mb-3'>
                    <label class='col-form-label'><b>Merk</b></label>
                    <input type='text' class='form-control' value='$produk->merk' name='merk' id='merk' readonly>
                  </div>
                </div>
                <div class='row'>
                  <div class='col-sm mb-3'>
                    <label class='col-form-label'><b>Nama Produk</b></label>
                    <input type='hidden' class='form-control' value='$produk->id_produk' name='id_produk' id='id_produk' readonly>
                    <input type='text' class='form-control' value='$produk->nama' name='nama' id='nama' readonly>
                  </div>
                </div>
                <div class='row'>
                  <div class='col-sm mb-3'>
                    <label class='col-form-label'><b>Deskripsi</b></label>
                    <textarea class='form-control' style='height:75px;' name='deskripsi' id='deskripsi' readonly>$produk->deskripsi</textarea>
                  </div>
                </div>
                <div class='row'>
                  <div class='col-sm-4 mb-3'>
                    <label class='col-form-label'><b>Harga</b></label>
                    <input type='number' min='1000' class='form-control' value='$produk->harga' name='harga' id='harga' readonly>
                  </div>
                  <div class='col-sm-4 mb-3'>
                    <label class='col-form-label'><b>Netto</b></label>
                    <input type='text' class='form-control' value='$produk->netto' name='netto' id='netto' readonly>
                  </div>
                  <div class='col-sm-4 mb-3'>
                    <label class='col-form-label'><b>Minimal Usia</b></label>
                    <div class='input-group'>
                      <input type='number' min='1' max='75' class='form-control' value='$produk->minimalusia' name='minimalusia' id='minimalusia' readonly>
                      <span class='input-group-text' style='height:3rem;'>Tahun</span>
                    </div>
                  </div>
                </div>
                <div class='row'>
                  <div class='col-sm-6'>
                    <div class='mb-3'>
                      <label class='col-form-label'><b>Untuk Jenis Kelamin</b></label>
                      ";
                      foreach($jeniskelamins as $jeniskelamin) {
                      echo "<br><input class='form-check-input' type='checkbox' value='$jeniskelamin->namasubkriteria' name='jeniskelamin[]' id='jeniskelamin' style='pointer-events: none;'"; if(str_contains($produk->jeniskelamin, $jeniskelamin->namasubkriteria)) { echo "checked=''"; } echo "><label class='form-check-label'>$jeniskelamin->namasubkriteria</label>";
                      }
                    echo "</div>
                    <div class='mb-3'>
                      <label class='col-form-label'><b>Komposisi Berbahaya</b></label><br>
                      <input class='form-check-input' type='checkbox'"; if(str_contains($produk->komposisiberbahaya, 'Alcohol')) { echo "checked=''"; } echo "value='Alcohol' name='komposisiberbahaya[]' id='komposisiberbahaya' style='pointer-events: none;'><label class='form-check-label'>Alcohol</label><br>
                      <input class='form-check-input' type='checkbox'"; if(str_contains($produk->komposisiberbahaya, 'Fragrance')) { echo "checked=''"; } echo "vvalue='Fragrance' name='komposisiberbahaya[]' id='komposisiberbahaya' style='pointer-events: none;'><label class='form-check-label'>Fragrance</label>";
                      if($produk->komposisiberbahaya == '') {
                        echo "<br><span class='badge badge-pill light badge-success'>Alcohol and Fragrance Free</span>";
                      }
                    echo "</div>
                  </div>
                  <div class='col-sm-6 mb-3'>
                    <label class='col-form-label'><b>Untuk Tipe Kulit</b></label>";
                    foreach($tipekulits as $tipekulit) {
                    echo "<br><input class='form-check-input' type='checkbox' value='$tipekulit->namasubkriteria' name='tipekulit[]' id='tipekulit' style='pointer-events: none;'"; if(str_contains($produk->tipekulit, $tipekulit->namasubkriteria)) { echo "checked=''"; } echo "><label class='form-check-label'>$tipekulit->namasubkriteria</label>";
                    }
                  echo "</div>
                </div>
              </div>
              <div class='col-sm-6 mb-3'>
                <label class='col-form-label'><b>Gambar</b></label>
                <div class='form-file'>";
                  if($produk->gambar) {
                    echo "<img src='".asset('storage/'.$produk->gambar)."' alt='Gambar Produk' style='width:100%;'>";
                  } else {
                    echo "<span class='badge badge-xs light badge-danger' style='margin:0 0 0.5rem 0.5rem;'>Belum ada foto produk.</span>";
                  }
                echo "</div>
              </div>
            </div>
          ";
        }
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }
}
