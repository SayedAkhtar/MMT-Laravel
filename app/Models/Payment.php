<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public const SUCCESS = "COMPLETED";
    public const FAILED = "FAILED";
    public const PENDING = "PENDING";
    public const INITIATED = "STARTED";
    protected $table = 'payments';
    protected $guarded = ['id'];
}
