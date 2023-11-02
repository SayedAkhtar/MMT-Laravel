<?php

namespace App\Models;

use App\Traits\HasRecordOwnerProperties;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use InteractsWithMedia;
    use HasRecordOwnerProperties;


    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'email',
        'phone',
        'email_verified_at',
        'remember_token',
        'is_active',
        'created_at',
        'updated_at',
        'added_by',
        'updated_by',
        'image',
        'gender',
        'country',
        'dob',
        'login_reactive_time',
        'login_retry_limit',
        'reset_password_expire_time',
        'reset_password_code',
        'user_type',
        'country_code',
        'local_auth',
        'support_call_id'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'name' => 'string',
        'username' => 'string',
        'password' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'remember_token' => 'string',
        'is_active' => 'boolean',
        'added_by' => 'integer',
        'updated_by' => 'integer',
        'image' => 'string',
        'gender' => 'string',
        'country' => 'integer',
        'dob' => 'date',
        'login_reactive_time' => 'datetime',
        'login_retry_limit' => 'integer',
        'reset_password_expire_time' => 'datetime',
        'reset_password_code' => 'string',
        'user_type' => 'integer',
    ];

    public const DEFAULT_ROLE = 'System User';

    public const TYPE_USER = 1;
    public const TYPE_ADMIN = 2;
    public const TYPE_HCF = 3;

    public const TYPE_DOCTOR = 4;

    public const USER_TYPE = [
        self::TYPE_USER => 'User',
        self::TYPE_ADMIN => 'Admin',
        self::TYPE_HCF => 'HCF',
        self::TYPE_DOCTOR,
    ];

    public const PLATFORM = [
        'DEVICE' => 1,
        'CLIENT' => 2,
    ];

    public const USER_ROLE = [
        'USER' => 1,
        'ADMIN' => 2,
        'HCF' => 3,
        'DOCTOR' => 4
    ];

    public const MAX_LOGIN_RETRY_LIMIT = 3;
    public const LOGIN_REACTIVE_TIME = 0;

    public const FORGOT_PASSWORD_WITH = [
        'link' => [
            'email' => false,
            'sms' => true,
        ],
        'expire_time' => '20',
    ];

    public const LOGIN_ACCESS = [
        'User' => [self::PLATFORM['CLIENT']],
        'Admin' => [self::PLATFORM['DEVICE']],
        'HCF' => [self::PLATFORM['CLIENT']],
    ];

    public function routeNotificationForFcm()
    {
        return $this->firebase_token;
    }

    public function routeNotificationForTwilio()
    {
        return $this->country_code . $this->phone; // e.g "+91909945XXXX"
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(150)
            ->height(150)
            ->optimize()
            ->sharpen(10);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function attachImage(string $key, string $library, bool $isMultiple)
    {
        if ($isMultiple) {
            $this->addMultipleMediaFromRequest([$key])->each(fn($fileAdder) => $fileAdder->toMediaCollection($library));
        } else {
            $this->addMediaFromRequest($key)->toMediaCollection($library);
        }
    }

    public function updateImage(string $key, string $library, bool $isMultiple)
    {
        if ($isMultiple) {
            $this->clearMediaCollection($library);
            return $this->addMultipleMediaFromRequest([$key])->each(fn($fileAdder) => $fileAdder->toMediaCollection($library));
        } else {
            $this->media()->delete();
            return $this->addMediaFromRequest($key)->toMediaCollection($library);
        }
    }

    public function role()
    {
        return $this->hasManyThrough(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }

    public function pastQuery()
    {
        return $this->belongsTo(PastQuery::class, 'user_id', 'id');
    }

    public function confirmedQuery()
    {
        return $this->hasMany(Query::class, 'coordinator_id', 'id');
    }

    public function patientQuery()
    {
        return $this->belongsTo(Query::class, 'patient_id', 'id');
    }

    public function patientFamilyQuery()
    {
        return $this->belongsTo(Query::class, 'patient_family_id', 'id');
    }

    public function doctorQuery()
    {
        return $this->belongsTo(Query::class, 'doctor_id', 'id');
    }

    public function patientTestimony()
    {
        return $this->belongsTo(PatientTestimony::class, 'patient_id', 'id');
    }

    public function doctorTestimony()
    {
        return $this->belongsTo(PatientTestimony::class, 'doctor_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'id', 'user_id');
    }

    public function patientFamilies()
    {
        return $this->hasMany(PatientFamily::class, 'patient_id', 'id');
    }

    public function patientDetails()
    {
        return $this->hasOne(PatientDetails::class, 'user_id', 'id');
    }

    public function patientFamilyDetails()
    {
        return $this->hasMany(PatientFamilyDetails::class, 'patient_id', 'id');
    }

    public function patient()
    {
        return $this->hasOneThrough(User::class, PatientDetails::class, 'user_id', 'id', '', 'user_id');
    }

    public function countryModel()
    {
        return $this->belongsTo(Country::class, 'country');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }


}
