<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoriproduk extends Model {
  use HasFactory;

  protected $table = "tbl_kategoriproduk";
  protected $primaryKey = "id_kategoriproduk";
}