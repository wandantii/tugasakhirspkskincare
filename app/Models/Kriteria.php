<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model {
  use HasFactory;

  protected $table = "tbl_kriteria";
  protected $primaryKey = "id_kriteria";
}