<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewReviews extends Model {
  use HasFactory;

  protected $table = "reviews";
  protected $primaryKey = "id_review";
}