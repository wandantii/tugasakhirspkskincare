<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewProduks extends Model {
  use HasFactory;

  protected $table = "produks";
  protected $primaryKey = "id_produk";
}