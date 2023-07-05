<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\SocialLogin;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class SocialLoginController.
 */
class SocialLoginController extends AppBaseController
{
    /**
     * @param $provider
     *
     * @return JsonResponse|RedirectResponse
     */
    public function redirectLogin($provider)
    {
        $provider = strtolower($provider);
        if (!in_array($provider, SocialLogin::SOCIAL_PROVIDERS)) {
            return $this->errorResponse('Invalid provider');
        }

        return Socialite::driver($provider)->redirect();
    }
}