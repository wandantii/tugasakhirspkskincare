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


class ReviewController extends Controller
{
  /* FRONT */
  /* Store a newly created resource in storage */
  public function frontstore(Request $request) {
    if(isset(auth()->user()->id_user)) {
      $validatedData = $request->validate([
        'review' => 'required|min:10|max:500'
      ]);
      $data = new Review;
      $data->id_user = $request->id_user;
      $data->id_produk = $request->id_produk;
      $data->review = $request->review;
      $data->save();
      return redirect('produk/'.$request->id_produk.'/show')->with('success','Berhasil membuat review.');
    } else {
      return redirect('/');
    }
  }

  /* Update the specified resource in storage */
  public function frontupdate(Request $request) {
    if(isset(auth()->user()->id_user)) {
      $getiduser = auth()->user()->id_user;
      $user = ViewUsers::find($getiduser);
      $validatedData = $request->validate([
        'review' => 'required|min:10|max:500'
      ]);
      $data = Review::where('id_user',$getiduser)->where('id_produk',$request->id_produk)->first();
      $data->id_user = $request->id_user;
      $data->id_produk = $request->id_produk;
      $data->review = $request->review;
      $data->save();
      return redirect('produk/'.$request->id_produk.'/show')->with('success','Berhasil memperbarui review.');
    } else {
      return redirect('/');
    }
  }
}
