<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subkriteria extends Model {
  use HasFactory;

  protected $table = "tbl_subkriteria";
  protected $primaryKey = "id_subkriteria";
}