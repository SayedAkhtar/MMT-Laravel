<?php

namespace App\Models;

use App\Traits\OnlyActive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory, OnlyActive;

    protected $fillable = ['name', 'short_code'];
}
