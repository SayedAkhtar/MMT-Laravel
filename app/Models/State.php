<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class State extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['name'];
    protected $fillable = ['name', 'short_form', 'country_id'];
}
