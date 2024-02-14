<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;

class Faq extends BaseModel
{
    use HasFactory, HasTranslations;
    public $translatable = ['question', 'answer'];
    protected $fillable = ['question', 'answer'];
}
