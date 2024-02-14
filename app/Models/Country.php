<?php

namespace App\Models;

use App\Traits\OnlyActive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Country extends Model
{
    use HasFactory, OnlyActive, HasTranslations;
    public $translatable = ['name'];
    protected $fillable = ['name', 'short_code'];
}
