<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class PushNotification extends Model
{
    /**
     * @var string
     */
    protected $table = 'push_notifications';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'device_id',
        'platform',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'device_id' => 'string',
        'platform' => 'string',
    ];
}
