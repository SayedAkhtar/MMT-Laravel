<?php

namespace App\Http\Middleware;

use App\Exceptions\LoginUnAuthorizeException;
use App\Models\User;
use App\Utils\ResponseUtil;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ValidateUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure  $next
     *
     * @throws LoginUnAuthorizeException
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user->email_verified_at) {
            return response()->json(ResponseUtil::generateError('UNAUTHORIZED','Your account is not verified.',
                'Your account is not verified.'), Response::HTTP_UNAUTHORIZED);
        }

        if (! $user->is_active) {
            return response()->json(ResponseUtil::generateError('UNAUTHORIZED','Your account is deactivated. please contact your administrator.',
                'Your account is deactivated. please contact your administrator.'), Response::HTTP_UNAUTHORIZED);

        }

        $roles = $user->getRoleNames();
        if (!$roles->count()) {
            throw new LoginUnAuthorizeException('You have not assigned any role');
        }
        $platform = $this->getPlatformNameFromUrl($request->url());
        if($roles->first() != User::DEFAULT_ROLE){
            if (is_null($user->user_type)){
                throw new LoginUnAuthorizeException('You have not assigned any user type.');
            }

            if(!in_array(User::PLATFORM[$platform],User::LOGIN_ACCESS[User::USER_TYPE[$user->user_type]])){
                throw new LoginUnAuthorizeException('you are unable to access this platform.');
            }
        }

        return $next($request);
    }

    /**
     * @param $url
     *
     * @return string
     */
    public function getPlatformNameFromUrl($url): string
    {
        $platform = '';
        switch ($url)
        {
            case (Str::contains($url,'api/admin')):
                $platform = 'ADMIN';
                break;
            case (Str::contains($url,'api/device')):
                $platform = 'DEVICE';
                break;
            case (Str::contains($url,'api/desktop')):
                $platform = 'DESKTOP';
                break;
            case (Str::contains($url,'api/client')):
                $platform = 'CLIENT';
                break;
        }

        return $platform;
    }
}
