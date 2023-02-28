<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\KategoriprodukController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NilaikriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Front - Login Logout */
Route::get('login', [LoginController::class, 'index'])->middleware('guest');
Route::post('login', [LoginController::class, 'authenticate']);
Route::post('logout', [LoginController::class, 'logout']);
/* Front - Register */
Route::get('register', [RegisterController::class, 'index']);
Route::post('register', [RegisterController::class, 'store']);
/* Front - Profil */
Route::get('profile', [UserController::class, 'profiluser']);
Route::put('profile/{id}', [UserController::class, 'updateuser']);
/* Front - Beranda */
Route::get('/', function () { return view('front/beranda'); });
/* Front - Produk */
Route::get('produk', [ProdukController::class, 'frontindex']);
Route::get('produk/{id}/show', [ProdukController::class, 'frontshow']);
/* Front - Review */
Route::post('review', [ReviewController::class, 'frontstore']);
Route::put('review', [ReviewController::class, 'frontupdate']);
/* Front - Copras */
Route::get('copras', [PenilaianController::class, 'coprasfront']);
Route::post('copras', [PenilaianController::class, 'coprasfrontbyfilter']);
/* Front - Moora */
Route::get('moora', [PenilaianController::class, 'moorafront']);
Route::post('moora', [PenilaianController::class, 'moorafrontbyfilter']);
/* Front - Perbandingan */
Route::get('perbandingan', [PenilaianController::class, 'perbandinganfront']);
Route::post('perbandingan', [PenilaianController::class, 'perbandinganfrontbyfilter']);


/* Admin - Login */
Route::get('admin/login', [LoginController::class, 'indexadmin'])->middleware('guest');
Route::post('admin/login', [LoginController::class, 'authenticateadmin']);
Route::post('admin/logout', [LoginController::class, 'logoutadmin']);
/* Admin - Register */
Route::get('admin/register', [RegisterController::class, 'indexadmin']);
Route::post('admin/register', [RegisterController::class, 'storeadmin']);
/* Admin - Profil */
Route::get('admin/profile', [UserController::class, 'profiladmin']);
Route::put('admin/profile/{id}', [UserController::class, 'updateadmin']);
/* Admin - Beranda */
Route::get('admin', [Controller::class, 'index']);
/* Admin - Kategori Produk */
Route::get('admin/kategoriproduk', [KategoriprodukController::class, 'index']);
Route::get('admin/kategoriproduk/create', [KategoriprodukController::class, 'create']);
Route::get('admin/kategoriproduk/{id}/edit', [KategoriprodukController::class, 'edit']);
Route::get('admin/kategoriproduk/{id}/show', [KategoriprodukController::class, 'show']);
Route::post('admin/kategoriproduk', [KategoriprodukController::class, 'store']);
Route::put('admin/kategoriproduk/{id}', [KategoriprodukController::class, 'update']);
Route::delete('admin/kategoriproduk/{id}', [KategoriprodukController::class, 'destroy']);
/* Admin - Produk */
Route::get('admin/produk', [ProdukController::class, 'index']);
Route::get('admin/produk/create', [ProdukController::class, 'create']);
Route::get('admin/produk/{id}/edit', [ProdukController::class, 'edit']);
Route::get('admin/produk/{id}/show', [ProdukController::class, 'show']);
Route::post('admin/produk', [ProdukController::class, 'store']);
Route::put('admin/produk/{id}', [ProdukController::class, 'update']);
Route::delete('admin/produk/{id}', [ProdukController::class, 'destroy']);
/* Admin - Kriteria */
Route::get('admin/kriteria', [KriteriaController::class, 'index']);
Route::get('admin/kriteria/create', [KriteriaController::class, 'create']);
Route::get('admin/kriteria/{id}/edit', [KriteriaController::class, 'edit']);
Route::get('admin/kriteria/{id}/show', [KriteriaController::class, 'show']);
Route::post('admin/kriteria', [KriteriaController::class, 'store']);
Route::put('admin/kriteria/{id}', [KriteriaController::class, 'update']);
Route::delete('admin/kriteria/{id}', [KriteriaController::class, 'destroy']);
/* Admin - Sub Kriteria */
Route::get('admin/subkriteria', [SubKriteriaController::class, 'index']);
Route::get('admin/subkriteria/create', [SubKriteriaController::class, 'create']);
Route::get('admin/subkriteria/{id}/edit', [SubKriteriaController::class, 'edit']);
Route::get('admin/subkriteria/{id}/show', [SubKriteriaController::class, 'show']);
Route::post('admin/subkriteria', [SubKriteriaController::class, 'store']);
Route::put('admin/subkriteria/{id}', [SubKriteriaController::class, 'update']);
Route::delete('admin/subkriteria/{id}', [SubKriteriaController::class, 'destroy']);
/* Admin - Nilai Kriteria */
Route::get('admin/nilaikriteria', [NilaikriteriaController::class, 'index']);
Route::get('admin/nilaikriteria/create', [NilaikriteriaController::class, 'create']);
Route::get('admin/nilaikriteria/{id}/edit', [NilaikriteriaController::class, 'edit']);
Route::get('admin/nilaikriteria/{id}/show', [NilaikriteriaController::class, 'show']);
Route::post('admin/nilaikriteria', [NilaikriteriaController::class, 'store']);
Route::put('admin/nilaikriteria/{id}', [NilaikriteriaController::class, 'update']);
Route::delete('admin/nilaikriteria/{id}', [NilaikriteriaController::class, 'destroy']);
/* Admin - Alternatif */
Route::get('admin/alternatif', [AlternatifController::class, 'index']);
Route::get('admin/alternatif/create', [AlternatifController::class, 'create']);
Route::get('admin/alternatif/{id}/edit', [AlternatifController::class, 'edit']);
Route::get('admin/alternatif/{id}/show', [AlternatifController::class, 'show']);
Route::post('admin/alternatif', [AlternatifController::class, 'store']);
Route::put('admin/alternatif/{id}', [AlternatifController::class, 'update']);
Route::delete('admin/alternatif/{id}', [AlternatifController::class, 'destroy']);
Route::post('getprodukbykategori', [AlternatifController::class, 'getprodukbykategori']);
Route::post('getprodukbykategorilagi', [AlternatifController::class, 'getprodukbykategorilagi']);
/* Admin - User */
Route::get('admin/user', [UserController::class, 'index']);;
Route::get('admin/user/{id}/show', [UserController::class, 'show']);
/* Admin - Penilaian */
Route::get('admin/penilaian', [PenilaianController::class, 'index']);
Route::get('admin/penilaian/{id}/show', [PenilaianController::class, 'show']);