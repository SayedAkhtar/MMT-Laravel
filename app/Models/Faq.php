<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends BaseModel
{
    use HasFactory;

    protected $fillable = ['question', 'answer'];
}
