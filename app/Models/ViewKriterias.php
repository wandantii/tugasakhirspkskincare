<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewKriterias extends Model {
  use HasFactory;

  protected $table = "kriterias";
  protected $primaryKey = "id_subkriteria";
}