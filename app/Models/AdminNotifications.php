<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotifications extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'notification_title', 'notification_body', 'notification_image', 'notification_url', 'status'];
}
