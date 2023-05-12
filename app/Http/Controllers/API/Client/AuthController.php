<?php

namespace App\Http\Controllers\API\Client;

use App\Exceptions\ChangePasswordFailureException;
use App\Exceptions\FailureResponseException;
use App\Exceptions\LoginFailedException;
use App\Exceptions\LoginUnAuthorizeException;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\ChangePasswordApiRequest;
use App\Http\Requests\Client\ForgotPasswordAPIRequest;
use App\Http\Requests\Client\LoginAPIRequest;
use App\Http\Requests\Client\RegisterAPIRequest;
use App\Http\Requests\Client\ResetPasswordAPIRequest;
use App\Http\Requests\Client\ValidateResetPasswordOtpApiRequest;
use App\Models\User;
use App\Notifications\SendSMSNotification;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Nette\Schema\ValidationException;
use Prettus\Validator\Exceptions\ValidatorException;
use Spatie\Permission\Models\Role;

class AuthController extends AppBaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param RegisterAPIRequest $request
     *
     * @return JsonResponse
     * @throws ValidatorException
     *
     */
    public function register(RegisterAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        if (isset($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }
        $input['user_type'] = User::TYPE_USER;

        /** @var User $user */
        $user = $this->userRepository->create($input);
        $data['username'] = $user->username;

        $userRole = Role::find($input['role']);
        $user->assignRole($userRole);
        $user->markEmailAsVerified();
        $user->otp = rand(4, 4);
        $data = $user->toArray();
        $data['token'] = $user->createToken('Client Login')->plainTextToken;

        return $this->successResponse($data);
    }

    /**
     * @param LoginAPIRequest $request
     *
     * @return JsonResponse
     * @throws LoginUnAuthorizeException
     *
     * @throws LoginFailedException
     */
    public function login(LoginAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        /** @var User $user */
        $user = User::where('phone', $input['phone'])->first();

        if (empty($user)) {
            throw new LoginFailedException('User not exists.');
        }

        if (!$user->email_verified_at) {
            throw new LoginUnAuthorizeException('Your account is not verified.');
        }

        if (!$user->is_active) {
            throw new LoginUnAuthorizeException('Your account is deactivated. please contact your administrator.');
        }

        if ($user->login_retry_limit >= User::MAX_LOGIN_RETRY_LIMIT) {
            $now = Carbon::now();
            if (empty($user->login_reactive_time)) {
                $expireTime = Carbon::now()->addMinutes(User::LOGIN_REACTIVE_TIME)->toISOString();
                $user->update([
                    'login_reactive_time' => $expireTime,
                    'login_retry_limit' => $user->login_retry_limit + 1,
                ]);
                throw new LoginFailedException('you have exceed the number of limit.you can login after ' . User::LOGIN_REACTIVE_TIME . ' minutes.');
            }

            $limitTime = Carbon::parse($user->login_reactive_time);
            if ($limitTime > $now) {
                $expireTime = Carbon::now()->addMinutes(User::LOGIN_REACTIVE_TIME)->toISOString();
                $user->update([
                    'login_reactive_time' => $expireTime,
                    'login_retry_limit' => $user->login_retry_limit + 1,
                ]);

                throw new LoginFailedException('you have exceed the number of limit.you can login after ' . User::LOGIN_REACTIVE_TIME . ' minutes.');
            }
        }

        if (!Hash::check($input['password'], $user->password)) {
            $user->update([
                'login_retry_limit' => $user->login_retry_limit + 1,
            ]);
            throw new LoginFailedException('Password is incorrect.');
        }
        $roles = $user->getRoleNames();
        if (!$roles->count()) {
            throw new LoginFailedException('You have not assigned any role.');
        }

        if (User::DEFAULT_ROLE != $roles->first()) {
            if (is_null($user->user_type)) {
                throw new LoginFailedException('You have not assigned any user type.');
            }

            if (!in_array(User::PLATFORM['CLIENT'], User::LOGIN_ACCESS[User::USER_TYPE[$user->user_type]])) {
                throw new LoginFailedException('you are unable to access this platform.');
            }
        }

        $data = $user->toArray();
        $data['token'] = $user->createToken('Client Login')->plainTextToken;

        $user->update([
            'login_reactive_time' => null,
            'login_retry_limit' => 0,
        ]);

        return $this->loginSuccess($data);
    }

    /**
     * Logout auth user.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->successResponse('Logout successfully.');
    }

    /**
     * This function send reset password mail or sms.
     *
     * @param ForgotPasswordAPIRequest $request
     *
     * @return JsonResponse
     * @throws FailureResponseException
     *
     */
    public function forgotPassword(ForgotPasswordAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        /** @var User $user */
        $user = User::where('phone', $input['phone'])->firstOrFail();

        $resultOfEmail = false;
        $resultOfSMS = false;
//        $code = $this->generateCode();
        $code = "123456";
        if (User::FORGOT_PASSWORD_WITH['link']['email']) {
            $resultOfEmail = $this->sendEmailForResetPasswordLink($user, $code);
        }
        if (User::FORGOT_PASSWORD_WITH['link']['sms']) {
            $resultOfSMS = $this->sendSMSForResetPasswordLink($user, $code);
        }

        if ($resultOfEmail && $resultOfSMS) {
            return $this->successResponse('otp successfully send.');
        } elseif ($resultOfEmail && !$resultOfSMS) {
            return $this->successResponse('otp successfully send to your email.');
        } elseif (!$resultOfEmail && $resultOfSMS) {
            return $this->successResponse('otp successfully send to your mobile number.');
        } else {
            throw new FailureResponseException('otp can not be sent due to some issue try again later.');
        }
    }

    /**
     * This function will send reset password email to given user.
     *
     * @param ResetPasswordAPIRequest $request
     *
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        /** @var User $user */
        $user = User::where('reset_password_code', $input['code'])->first();
        if ($user && $user->reset_password_expire_time) {
            if (Carbon::now()->isAfter($user->reset_password_expire_time)) {
                return $this->errorResponse('Your reset password link is expired on invalid.');
            }
        } else {
            return $this->errorResponse('Invalid Code.');
        }

        $user->update([
            'password' => Hash::make($input['new_password']),
            'reset_password_expire_time' => null,
            'login_retry_limit' => 0,
            'reset_password_code' => null,
        ]);

        $data['username'] = $user->username;
        $data['message'] = 'Your Password Successfully Reset';
//        Mail::to($user->email)
//            ->send(new MailService('emails.password_reset_success',
//                'Reset Password',
//                $data));

        return $this->successResponse('Password reset successful.');
    }

    /**
     * @param ValidateResetPasswordOtpApiRequest $request
     *
     * @return JsonResponse
     */
    public function validateResetPasswordOtp(ValidateResetPasswordOtpApiRequest $request): JsonResponse
    {
        $input = $request->all();
        /** @var User $user */
        $user = User::where('reset_password_code', $input['otp'])->first();
        if (!$user || !$user->reset_password_expire_time) {
            return $this->errorResponse('Invalid OTP.');
        }

        // link expire
        if (Carbon::now()->isAfter($user->reset_password_expire_time)) {
            return $this->errorResponse('Your reset password link is expired or invalid.');
        }

        return $this->successResponse('Otp verified.');
    }

    /**
     * @param        $user
     * @param string $code
     *
     * @return bool
     */
    public function sendOTPForResetPasswordLink($user, string $code): bool
    {
        $expireTime = Carbon::now()->addMinutes(User::FORGOT_PASSWORD_WITH['expire_time'])->toISOString();
        $user->update([
            'reset_password_expire_time' => $expireTime,
            'reset_password_code' => $code,
        ]);

        // mail send code
        $data['code'] = $code;
        $data['expireTime'] = User::FORGOT_PASSWORD_WITH['expire_time'];
        $data['message'] = 'Please use below code to reset your password.';
//        Mail::to($user->email)
//            ->send(new MailService('emails.ResetPassword',
//                'Reset Password',
//                $data));

        return true;
    }

    /**
     * @param        $user
     * @param string $code
     *
     * @return bool
     */
    public function sendSMSForResetPasswordLink($user, string $code): bool
    {
        $expireTime = Carbon::now()->addMinutes(User::FORGOT_PASSWORD_WITH['expire_time'])->toISOString();
        $user->update([
            'reset_password_expire_time' => $expireTime,
            'reset_password_code' => $code,
        ]);

        // sms send code
        $user->notify(new SendSMSNotification());

        return true;
    }

    /**
     * Change password of logged in user.
     *
     * @param ChangePasswordApiRequest $request
     *
     * @return JsonResponse
     * @throws ChangePasswordFailureException
     *
     */
    public function changePassword(ChangePasswordApiRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var User $user */
        $user = Auth::user();
        if (!Hash::check($input['old_password'], $user->password)) {
            throw new ChangePasswordFailureException('Current password is invalid.');
        }
        $input['password'] = Hash::make($input['new_password']);
        $user->update($input);

        return $this->changePasswordSuccess('Password Updated Successfully.');
    }

    /**
     * Generate unique code to reset password of given user.
     *
     * @return string
     */
    public function generateCode(): string
    {
        $code = Str::random(6);
        while (true) {
            $codeExists = User::where('reset_password_code', $code)->exists();
            if ($codeExists) {
                return $this->generateCode();
            }
            break;
        }

        return $code;
    }

    public function validateToken(Request $request)
    {
        $user = User::find(Auth::id());
        $user->getRoleNames();
        $data = $user->toArray();
        return $this->loginSuccess($data);
    }

    public function resendOtp()
    {
        $user = User::find(Auth::id());
        $phone = $user->phone;
    }

    public function validateOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|min:4',
            'phone' => 'required| exists:users,phone'
        ]);
        try {
            $user = User::where('phone', $request->phone)->first();
            if ($user->otp == $request->input('otp')) {
                return $this->successResponse('Otp Verified');
            }
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return $this->errorResponse("Internal server error " . $e->getMessage());
        }
        return $this->errorResponse("User Not found", 404);

    }
}
