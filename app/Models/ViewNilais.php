<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewNilais extends Model {
  use HasFactory;

  protected $table = "nilais";
  protected $primaryKey = "id_nilai";
}