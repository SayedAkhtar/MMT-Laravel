<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLogin extends Model
{
    protected $table = 'social_logins';

    protected $fillable = [
        'provider',
        'user_id',
        'provider_id',
        'meta',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'provider' => 'string',
        'user_id' => 'integer',
        'provider_id' => 'string',
        'meta' => 'object',
    ];

    public const GOOGLE_PROVIDER = 'google';
    public const FACEBOOK_PROVIDER = 'facebook';
    public const LINKEDIN_PROVIDER = 'linkedin';
    public const GITHUB_PROVIDER = 'github';

    public const SOCIAL_PROVIDERS = [
        self::GOOGLE_PROVIDER,
        self::FACEBOOK_PROVIDER,
        self::LINKEDIN_PROVIDER,
        self::GITHUB_PROVIDER,
    ];

    public static function facebookFields()
    {
        return [
            'first_name',
            'email',
            'gender',
            'id',
            'last_name',
            'name',
            'location',
            'verified',
            'birthday',
            'link',
            'locale',
        ];
    }
}
