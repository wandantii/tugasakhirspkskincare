<?php

namespace App\Http\Controllers;

use DB;
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


class PenilaianController extends Controller
{
  /* FRONT */
  /* Display a listing of the resource */
  public function coprasfront() {
    if(isset(auth()->user()->id_user)) {
      $reqbrand = '';
      $reqmin = '';
      $reqmax = '';
      $id_user = auth()->user()->id_user;
      $data = ViewUsers::where('id_user', '=', $id_user)->first();
      $alternatifs = Alternatif::all();
      if(isset(auth()->user()->usia)) {
        $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->orderBy('merk')->get();
        $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->get();
        $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->get();
        $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->get();
        $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->get();
      } else {
        $produks = ViewProduks::where('alternatif','Done')->orderBy('merk')->get();
        $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('id_subkriteria', $data->jeniskelamin)->get();
        $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('id_subkriteria', $data->tipekulit)->get();
        $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('id_kriteria', '4')->get();
        $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('id_kriteria', '5')->get();
      }
      $viewprodukberalternatifs = DB::table('alternatifs')
                                  ->select('id_produk', 'id_kategoriproduk', DB::raw('count(*) as total'))
                                  ->groupBy('id_produk')
                                  ->get();
      $kategoriproduks = Kategoriproduk::orderBy('nama')->get();
      $kriterias = Kriteria::all();
      $brands = ViewBrands::orderBy('merk', 'asc')->get();
      $produkcount = $produks->count();
      return view('front.copras.index', compact(
        'data', 'kategoriproduks', 'kriterias', 'alternatifs', 'produks', 'produkcount', 'byjeniskelamins', 'bytipekulits', 'bykemudahanpencarians', 'bykomposisiberbahayas', 'viewprodukberalternatifs', 'brands', 'reqbrand', 'reqmin', 'reqmax'
      ));
    } else {
      return redirect('/');
    }
  }
  
  /* Display a listing of the resource */
  public function coprasfrontbyfilter(Request $request) {
    if(isset(auth()->user()->id_user)) {
      $id_user = auth()->user()->id_user;
      $data = ViewUsers::where('id_user', '=', $id_user)->first();
      // Jika ada request minimal
      if(!empty($request->input('reqmin'))) {
        if(str_contains($request->input('reqmin'), ',')) {
          $reqmin = str_replace(',', '', $request->input('reqmin'));
        } elseif(str_contains($request->input('reqmin'), '.')) {
          $reqmin = str_replace('.', '', $request->input('reqmin'));
        } else {
          $reqmin = $request->input('reqmin');
        }
      } else {
        $reqmin = '';
      }
      // Jika ada request maksimal
      if(!empty($request->input('reqmax'))) {
        if(str_contains($request->input('reqmax'), ',')) {
          $reqmax = str_replace(',', '', $request->input('reqmax'));
        } elseif(str_contains($request->input('reqmax'), '.')) {
          $reqmax = str_replace('.', '', $request->input('reqmax'));
        } else {
          $reqmax = $request->input('reqmax');
        }
      } else {
        $reqmax = '';
      }
      // Jika ada request brand
      if(!empty($request->input('reqbrand'))) {
        $reqbrand = join(',', $request->input('reqbrand'));
      } else {
        $reqbrand = '';
      }
      if(!empty($request->input('reqbrand'))) {
        $findbrand = explode(',', $reqbrand);
        if(isset(auth()->user()->usia)) {
          if(!empty($request->input('reqmin')) && !empty($request->input('reqmax'))) {
            // START Jika ada minimal dan maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->get();
            // END Jika ada minimal dan maksimal
          } elseif(empty($request->input('reqmin')) && !empty($request->input('reqmax'))) { 
            // START Jika tidak ada minimal dan ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->get();
            // END Jika ada minimal dan tidak ada maksimal
          } elseif(!empty($request->input('reqmin')) && empty($request->input('reqmax'))) {
            // START Jika ada minimal dan tidak ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->get();
            // END Jika ada tidak ada minimal dan maksimal
          } else {
            // START Jika tidak ada minimal dan tidak ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->get();
            // END Jika ada tidak ada minimal dan tidak ada maksimal
          }
        } else {
          $produks = ViewProduks::where('alternatif','Done')->orderBy('merk', 'asc')->get();
        }
      } else {
        if(isset(auth()->user()->usia)) {
          if(!empty($request->input('reqmin')) && !empty($request->input('reqmax'))) {
            // START Jika ada minimal dan ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->whereBetween('harga', [$reqmin, $reqmax])->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->whereBetween('harga', [$reqmin, $reqmax])->get();
            // END Jika ada minimal dan ada maksimal
          } elseif(empty($request->input('reqmin')) && !empty($request->input('reqmax'))) {
            // START Jika tidak ada minimal dan ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('harga', '<=', $reqmax)->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where('harga', '<=', $reqmax)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where('harga', '<=', $reqmax)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where('harga', '<=', $reqmax)->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where('harga', '<=', $reqmax)->get();
            // END Jika tidak ada minimal dan ada maksimal
          } elseif(!empty($request->input('reqmin')) && empty($request->input('reqmax'))) {
            // START Jika ada minimal dan tidak ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('harga', '>=', $request->input('reqmin'))->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where('harga', '>=', $reqmin)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where('harga', '>=', $reqmin)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where('harga', '>=', $reqmin)->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where('harga', '>=', $reqmin)->get();
            // END Jika ada minimal dan tidak ada maksimal
          } else {
            // START Jika tidak ada minimal dan tidak ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->get();
            // END Jika ada tidak ada minimal dan tidak ada maksimal
          }
        } else {
          $produks = ViewProduks::where('alternatif','Done')->orderBy('merk', 'asc')->et();
        }
      }
      $alternatifs = Alternatif::all();
      $viewprodukberalternatifs = DB::table('alternatifs')
                                  ->select('id_produk', 'id_kategoriproduk', DB::raw('count(*) as total'))
                                  ->groupBy('id_produk')
                                  ->get();
      $kategoriproduks = Kategoriproduk::orderBy('nama')->get();
      $kriterias = Kriteria::all();
      $brands = ViewBrands::orderBy('merk', 'asc')->get();
      $produkcount = $produks->count();
      return view('front.copras.index', compact(
        'data', 'kategoriproduks', 'kriterias', 'alternatifs', 'produks', 'produkcount', 'byjeniskelamins', 'bytipekulits', 'bykemudahanpencarians', 'bykomposisiberbahayas', 'viewprodukberalternatifs', 'brands', 'reqbrand', 'reqmin', 'reqmax'
      ));
    } else {
      return redirect('/');
    }
  }

  /* Display a listing of the resource */
  public function moorafront() {
    if(isset(auth()->user()->id_user)) {
      $reqbrand = '';
      $reqmin = '';
      $reqmax = '';
      $id_user = auth()->user()->id_user;
      $data = ViewUsers::where('id_user', '=', $id_user)->first();
      $alternatifs = Alternatif::all();
      if(isset(auth()->user()->usia)) {
        $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->orderBy('merk')->get();
        $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->get();
        $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->get();
        $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->get();
        $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->get();
      } else {
        $produks = ViewProduks::where('alternatif','Done')->orderBy('merk')->get();
        $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('id_subkriteria', $data->jeniskelamin)->get();
        $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('id_subkriteria', $data->tipekulit)->get();
        $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('id_kriteria', '4')->get();
        $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('id_kriteria', '5')->get();
      }
      $viewprodukberalternatifs = DB::table('alternatifs')
                                  ->select('id_produk', 'id_kategoriproduk', DB::raw('count(*) as total'))
                                  ->groupBy('id_produk')
                                  ->get();
      $kategoriproduks = Kategoriproduk::orderBy('nama')->get();
      $kriterias = Kriteria::all();
      $brands = ViewBrands::orderBy('merk', 'asc')->get();
      $produkcount = $produks->count();
      return view('front.moora.index', compact(
        'data', 'kategoriproduks', 'kriterias', 'alternatifs', 'produks', 'produkcount', 'byjeniskelamins', 'bytipekulits', 'bykemudahanpencarians', 'bykomposisiberbahayas', 'viewprodukberalternatifs', 'brands', 'reqbrand', 'reqmin', 'reqmax'
      ));
    } else {
      return redirect('/');
    }
  }
  
  /* Display a listing of the resource */
  public function moorafrontbyfilter(Request $request) {
    if(isset(auth()->user()->id_user)) {
      $id_user = auth()->user()->id_user;
      $data = ViewUsers::where('id_user', '=', $id_user)->first();
      // Jika ada request minimal
      if(!empty($request->input('reqmin'))) {
        if(str_contains($request->input('reqmin'), ',')) {
          $reqmin = str_replace(',', '', $request->input('reqmin'));
        } elseif(str_contains($request->input('reqmin'), '.')) {
          $reqmin = str_replace('.', '', $request->input('reqmin'));
        } else {
          $reqmin = $request->input('reqmin');
        }
      } else {
        $reqmin = '';
      }
      // Jika ada request maksimal
      if(!empty($request->input('reqmax'))) {
        if(str_contains($request->input('reqmax'), ',')) {
          $reqmax = str_replace(',', '', $request->input('reqmax'));
        } elseif(str_contains($request->input('reqmax'), '.')) {
          $reqmax = str_replace('.', '', $request->input('reqmax'));
        } else {
          $reqmax = $request->input('reqmax');
        }
      } else {
        $reqmax = '';
      }
      // Jika ada request brand
      if(!empty($request->input('reqbrand'))) {
        $reqbrand = join(',', $request->input('reqbrand'));
      } else {
        $reqbrand = '';
      }
      if(!empty($request->input('reqbrand'))) {
        $findbrand = explode(',', $reqbrand);
        if(isset(auth()->user()->usia)) {
          if(!empty($request->input('reqmin')) && !empty($request->input('reqmax'))) {
            // START Jika ada minimal dan maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->get();
            // END Jika ada minimal dan maksimal
          } elseif(empty($request->input('reqmin')) && !empty($request->input('reqmax'))) { 
            // START Jika tidak ada minimal dan ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->get();
            // END Jika ada minimal dan tidak ada maksimal
          } elseif(!empty($request->input('reqmin')) && empty($request->input('reqmax'))) {
            // START Jika ada minimal dan tidak ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->get();
            // END Jika ada tidak ada minimal dan maksimal
          } else {
            // START Jika tidak ada minimal dan tidak ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->get();
            // END Jika ada tidak ada minimal dan tidak ada maksimal
          }
        } else {
          $produks = ViewProduks::where('alternatif','Done')->orderBy('merk', 'asc')->get();
        }
      } else {
        if(isset(auth()->user()->usia)) {
          if(!empty($request->input('reqmin')) && !empty($request->input('reqmax'))) {
            // START Jika ada minimal dan ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->whereBetween('harga', [$reqmin, $reqmax])->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->whereBetween('harga', [$reqmin, $reqmax])->get();
            // END Jika ada minimal dan ada maksimal
          } elseif(empty($request->input('reqmin')) && !empty($request->input('reqmax'))) {
            // START Jika tidak ada minimal dan ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('harga', '<=', $reqmax)->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where('harga', '<=', $reqmax)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where('harga', '<=', $reqmax)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where('harga', '<=', $reqmax)->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where('harga', '<=', $reqmax)->get();
            // END Jika tidak ada minimal dan ada maksimal
          } elseif(!empty($request->input('reqmin')) && empty($request->input('reqmax'))) {
            // START Jika ada minimal dan tidak ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('harga', '>=', $request->input('reqmin'))->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where('harga', '>=', $reqmin)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where('harga', '>=', $reqmin)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where('harga', '>=', $reqmin)->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where('harga', '>=', $reqmin)->get();
            // END Jika ada minimal dan tidak ada maksimal
          } else {
            // START Jika tidak ada minimal dan tidak ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->get();
            // END Jika ada tidak ada minimal dan tidak ada maksimal
          }
        } else {
          $produks = ViewProduks::where('alternatif','Done')->orderBy('merk', 'asc')->et();
        }
      }
      $alternatifs = Alternatif::all();
      $viewprodukberalternatifs = DB::table('alternatifs')
                                  ->select('id_produk', 'id_kategoriproduk', DB::raw('count(*) as total'))
                                  ->groupBy('id_produk')
                                  ->get();
      $kategoriproduks = Kategoriproduk::orderBy('nama')->get();
      $kriterias = Kriteria::all();
      $brands = ViewBrands::orderBy('merk', 'asc')->get();
      $produkcount = $produks->count();
      return view('front.moora.index', compact(
        'data', 'kategoriproduks', 'kriterias', 'alternatifs', 'produks', 'produkcount', 'byjeniskelamins', 'bytipekulits', 'bykemudahanpencarians', 'bykomposisiberbahayas', 'viewprodukberalternatifs', 'brands', 'reqbrand', 'reqmin', 'reqmax'
      ));
    } else {
      return redirect('/');
    }
  }

  /* Display a listing of the resource */
  public function perbandinganfront() {
    if(isset(auth()->user()->id_user)) {
      $reqbrand = '';
      $reqmin = '';
      $reqmax = '';
      $id_user = auth()->user()->id_user;
      $data = ViewUsers::where('id_user', '=', $id_user)->first();
      $alternatifs = Alternatif::all();
      if(isset(auth()->user()->usia)) {
        $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->orderBy('merk')->get();
        $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->get();
        $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->get();
        $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->get();
        $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->get();
      } else {
        $produks = ViewProduks::where('alternatif','Done')->orderBy('merk')->get();
        $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('id_subkriteria', $data->jeniskelamin)->get();
        $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('id_subkriteria', $data->tipekulit)->get();
        $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('id_kriteria', '4')->get();
        $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('id_kriteria', '5')->get();
      }
      $viewprodukberalternatifs = DB::table('alternatifs')
                                  ->select('id_produk', 'id_kategoriproduk', DB::raw('count(*) as total'))
                                  ->groupBy('id_produk')
                                  ->get();
      $kategoriproduks = Kategoriproduk::orderBy('nama')->get();
      $kriterias = Kriteria::all();
      $brands = ViewBrands::orderBy('merk', 'asc')->get();
      $produkcount = $produks->count();
      return view('front.perbandingan.index', compact(
        'data', 'kategoriproduks', 'kriterias', 'alternatifs', 'produks', 'produkcount', 'byjeniskelamins', 'bytipekulits', 'bykemudahanpencarians', 'bykomposisiberbahayas', 'viewprodukberalternatifs', 'brands', 'reqbrand', 'reqmin', 'reqmax'
      ));
    } else {
      return redirect('/');
    }
  }
  
  /* Display a listing of the resource */
  public function perbandinganfrontbyfilter(Request $request) {
    if(isset(auth()->user()->id_user)) {
      $id_user = auth()->user()->id_user;
      $data = ViewUsers::where('id_user', '=', $id_user)->first();
      // Jika ada request minimal
      if(!empty($request->input('reqmin'))) {
        if(str_contains($request->input('reqmin'), ',')) {
          $reqmin = str_replace(',', '', $request->input('reqmin'));
        } elseif(str_contains($request->input('reqmin'), '.')) {
          $reqmin = str_replace('.', '', $request->input('reqmin'));
        } else {
          $reqmin = $request->input('reqmin');
        }
      } else {
        $reqmin = '';
      }
      // Jika ada request maksimal
      if(!empty($request->input('reqmax'))) {
        if(str_contains($request->input('reqmax'), ',')) {
          $reqmax = str_replace(',', '', $request->input('reqmax'));
        } elseif(str_contains($request->input('reqmax'), '.')) {
          $reqmax = str_replace('.', '', $request->input('reqmax'));
        } else {
          $reqmax = $request->input('reqmax');
        }
      } else {
        $reqmax = '';
      }
      // Jika ada request brand
      if(!empty($request->input('reqbrand'))) {
        $reqbrand = join(',', $request->input('reqbrand'));
      } else {
        $reqbrand = '';
      }
      if(!empty($request->input('reqbrand'))) {
        $findbrand = explode(',', $reqbrand);
        if(isset(auth()->user()->usia)) {
          if(!empty($request->input('reqmin')) && !empty($request->input('reqmax'))) {
            // START Jika ada minimal dan maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->whereBetween('harga', [$reqmin, $reqmax])->get();
            // END Jika ada minimal dan maksimal
          } elseif(empty($request->input('reqmin')) && !empty($request->input('reqmax'))) { 
            // START Jika tidak ada minimal dan ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '<=', $reqmax)->get();
            // END Jika ada minimal dan tidak ada maksimal
          } elseif(!empty($request->input('reqmin')) && empty($request->input('reqmax'))) {
            // START Jika ada minimal dan tidak ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->where('harga', '>=', $reqmin)->get();
            // END Jika ada tidak ada minimal dan maksimal
          } else {
            // START Jika tidak ada minimal dan tidak ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where(function ($q) use ($findbrand) {
              foreach ($findbrand as $value) {
                $q->orWhere('merk', 'like', $value);
              }
            })->get();
            // END Jika ada tidak ada minimal dan tidak ada maksimal
          }
        } else {
          $produks = ViewProduks::where('alternatif','Done')->orderBy('merk', 'asc')->get();
        }
      } else {
        if(isset(auth()->user()->usia)) {
          if(!empty($request->input('reqmin')) && !empty($request->input('reqmax'))) {
            // START Jika ada minimal dan ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->whereBetween('harga', [$reqmin, $reqmax])->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->whereBetween('harga', [$reqmin, $reqmax])->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->whereBetween('harga', [$reqmin, $reqmax])->get();
            // END Jika ada minimal dan ada maksimal
          } elseif(empty($request->input('reqmin')) && !empty($request->input('reqmax'))) {
            // START Jika tidak ada minimal dan ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('harga', '<=', $reqmax)->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where('harga', '<=', $reqmax)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where('harga', '<=', $reqmax)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where('harga', '<=', $reqmax)->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where('harga', '<=', $reqmax)->get();
            // END Jika tidak ada minimal dan ada maksimal
          } elseif(!empty($request->input('reqmin')) && empty($request->input('reqmax'))) {
            // START Jika ada minimal dan tidak ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('harga', '>=', $request->input('reqmin'))->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->where('harga', '>=', $reqmin)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->where('harga', '>=', $reqmin)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->where('harga', '>=', $reqmin)->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->where('harga', '>=', $reqmin)->get();
            // END Jika ada minimal dan tidak ada maksimal
          } else {
            // START Jika tidak ada minimal dan tidak ada maksimal
            $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->orderBy('merk', 'asc')->get();
            $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->jeniskelamin)->get();
            $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_subkriteria', $data->tipekulit)->get();
            $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '4')->get();
            $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', auth()->user()->usia)->where('id_kriteria', '5')->get();
            // END Jika ada tidak ada minimal dan tidak ada maksimal
          }
        } else {
          $produks = ViewProduks::where('alternatif','Done')->orderBy('merk', 'asc')->et();
        }
      }
      $alternatifs = Alternatif::all();
      $viewprodukberalternatifs = DB::table('alternatifs')
                                  ->select('id_produk', 'id_kategoriproduk', DB::raw('count(*) as total'))
                                  ->groupBy('id_produk')
                                  ->get();
      $kategoriproduks = Kategoriproduk::orderBy('nama')->get();
      $kriterias = Kriteria::all();
      $brands = ViewBrands::orderBy('merk', 'asc')->get();
      $produkcount = $produks->count();
      return view('front.perbandingan.index', compact(
        'data', 'kategoriproduks', 'kriterias', 'alternatifs', 'produks', 'produkcount', 'byjeniskelamins', 'bytipekulits', 'bykemudahanpencarians', 'bykomposisiberbahayas', 'viewprodukberalternatifs', 'brands', 'reqbrand', 'reqmin', 'reqmax'
      ));
    } else {
      return redirect('/');
    }
  }



  /* ADMIN */
  /* Display a listing of the resource */
  public function index() {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = ViewUsers::all();
        return view('admin.penilaian.index', compact(
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
        $data = new Alternatif;
        $kategoriproduks = Kategoriproduk::all();
        $produks = Produk::all();
        $kriterias = Kriteria::all();
        $subkriterias = Subkriteria::all();
        $nilais = Nilaikriteria::all();
        $users = ViewUsers::all();
        return view('admin.penilaian.create', compact(
          'data', 'kategoriproduks', 'produks', 'kriterias', 'subkriterias', 'nilais', 'users'
        ));
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }
  
  /* Display the specified resource */
  public function show($id_users) {
    if(isset(auth()->user()->id_user)) {
      $level_user = auth()->user()->level;
      if($level_user == 'Admin') {
        $data = ViewUsers::find($id_users);
        $alternatifs = Alternatif::all();
        $viewprodukberalternatifs = DB::table('alternatifs')
                                    ->select('id_produk', 'id_kategoriproduk', DB::raw('count(*) as total'))
                                    ->groupBy('id_produk')
                                    ->get();
        $kategoriproduks = Kategoriproduk::orderBy('nama')->get();
        $kriterias = Kriteria::all();
        $produks = ViewProduks::where('alternatif','Done')->where('minimalusia', '<=', $data->usia)->orderBy('merk')->get();
        $byjeniskelamins = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', $data->usia)->where('id_subkriteria', $data->jeniskelamin)->get();
        $bytipekulits = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', $data->usia)->where('id_subkriteria', $data->tipekulit)->get();
        $bykemudahanpencarians = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', $data->usia)->where('id_kriteria', '4')->get();
        $bykomposisiberbahayas = ViewAlternatifs::where('alternatif','Done')->where('minimalusia', '<=', $data->usia)->where('id_kriteria', '5')->get();
        return view('admin.penilaian.show', compact(
          'data', 'kategoriproduks', 'kriterias', 'alternatifs', 'produks', 'byjeniskelamins', 'bytipekulits', 'bykemudahanpencarians', 'bykomposisiberbahayas', 'viewprodukberalternatifs'
        ));
      } else {
        return redirect('admin/login')->with('error', 'Maaf, anda bukan admin.');
      }
    } else {
      return redirect('/');
    }
  }
}
