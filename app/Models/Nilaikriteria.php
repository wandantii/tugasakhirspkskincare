<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilaikriteria extends Model {
  use HasFactory;

  protected $table = "tbl_nilai";
  protected $primaryKey = "id_nilai";
}