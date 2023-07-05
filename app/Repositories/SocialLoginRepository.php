<?php

namespace App\Repositories;

use App\Models\SocialLogin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class SocialAuthRepository.
 */
class SocialLoginRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'provider',
    ];

    /**
     * Return searchable fields.
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model.
     **/
    public function model(): string
    {
        return SocialLogin::class;
    }

    /**
     * @param string $provider
     * @param array  $socialUser
     *
     * @return array
     */
    public function socialLogin(string $provider, array $socialUser): array
    {
        $user = $this->handleSocialUser($provider, $socialUser);
        $data = $user->toArray();
        $data['token'] = $user->createToken('Client Login')->plainTextToken;

        return $data;
    }

    /**
     * @param string $provider
     * @param array  $socialUser
     *
     * @return User
     */
    public function handleSocialUser(string $provider, array $socialUser): User
    {
        $userData = [];

        switch (strtolower($provider)) {
            case SocialLogin::GOOGLE_PROVIDER:
                $userData = $this->prepareGoogleUserData($socialUser);
                break;

            case SocialLogin::FACEBOOK_PROVIDER:
                $userData = $this->prepareFacebookUserData($socialUser);
                break;
        }

        $user = User::whereRaw('lower(email) = ?', strtolower($userData['email']))->first();

        $existingProfile = null;
        if (!empty($user)) {
            /** @var SocialLogin $existingProfile */
            $existingProfile = SocialLogin::whereProvider($provider)->whereUserId($user->id)->first();
        }

        if (empty($user)) {
            if (empty($userData['email'])) {
                $userData['email'] = '###'.rand(1, 999).'###@domain.com';
            }
            $userData['is_active'] = true;
            $userData['email_verified_at'] = (!empty($userData['email'])) ? Carbon::now() : null;
            $userData['password'] = Hash::make(uniqid());

            $user = User::create($userData);
        }

        if (empty($existingProfile)) {
            $socialAccount = new SocialLogin();
            $socialAccount->user_id = $user->id;
            $socialAccount->provider = $provider;
            $socialAccount->provider_id = $userData['provider_id'];
            $socialAccount->save();
        }

        return $user;
    }

    /**
     * @param array $user
     *
     * @return array
     */
    public function prepareGoogleUserData(array $user): array
    {
        return [
            'email' => $user['email'],
            'provider_id' => $user['sub'],
            'username' => (!empty($user['email'])) ? Str::before($user['email'], '@') : '',
            // extra details into $user picture (photo) ,email_verified (is email verified),name (full name)
        ];
    }

    /**
     * @param $user
     *
     * @return array
     */
    public function prepareFacebookUserData($user): array
    {
        return [
            'email' => (!empty($user['email'])) ? $user['email'] : '',
            'provider_id' => $user['id'],
            'username' => (!empty($user['email'])) ? Str::before($user['email'], '@') : '',
        ];
    }
}
