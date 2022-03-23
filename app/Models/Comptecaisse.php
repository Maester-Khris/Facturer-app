<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ComptecaisseTrait;

class Comptecaisse extends Model
{
    use HasFactory;
    use ComptecaisseTrait;
}
