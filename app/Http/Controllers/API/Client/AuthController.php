<?php

namespace App\Http\Controllers\API\Client;

use App\Models\User;
use App\Models\Language;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Craftsys\Msg91\Facade\Msg91;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravolt\Avatar\Facade as Avatar;
use Nette\Schema\ValidationException;
use App\Exceptions\LoginFailedException;
use App\Notifications\SendSMSNotification;
use App\Http\Controllers\AppBaseController;
use App\Exceptions\FailureResponseException;
use App\Exceptions\LoginUnAuthorizeException;
use App\Http\Requests\Client\LoginAPIRequest;
use App\Http\Requests\Client\RegisterAPIRequest;
use App\Exceptions\ChangePasswordFailureException;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\Client\ResetPasswordAPIRequest;
use App\Http\Requests\Client\ChangePasswordApiRequest;
use App\Http\Requests\Client\ForgotPasswordAPIRequest;
use App\Http\Requests\Client\ValidateResetPasswordOtpApiRequest;

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
        try {
            DB::beginTransaction();
            $user = $this->userRepository->create($input);
            $data['username'] = $user->username;

            $userRole = Role::find($input['role']);
            $user->assignRole($userRole);
            $user->markEmailAsVerified();
            // $user->otp = rand(100000,999999);
            $user->otp = 987654;
            $t = Avatar::create($user->name)->toBase64();
            $user->patientDetails()->create();
            $user->patientDetails->addMediaFromBase64($t)->usingFileName(Str::random(30).'.png')->toMediaCollection('avatar');
            $data['avatar'] = $user->patientDetails->getMedia('avatar')->first()->getUrl();
            $user->is_active = false;
            $user->save();
            if(sendMsg91OTP($user->country_code . $user->phone, $user->otp) != 'success'){
                throw new \Exception("Cannot Send OTP. Please try again in some time", 100);
            }
            DB::commit();
            
            // $data = $user->toArray();
            // $data['token'] = $user->createToken('Client Login')->plainTextToken;
            // $user->patientDetails()->create();
            // $t = Avatar::create($user->name)->toBase64();
            // $user->patientDetails->addMediaFromBase64($t)->toMediaCollection('avatar');
            // $data['avatar'] = $user->patientDetails->getMedia('avatar')->first()->getUrl();

        } 
        catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            if($e->getCode() == 100){
                return $this->errorResponse($e->getMessage());
            }
            return $this->errorResponse("Cannot Create User. Please try again in some time");
        }

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
        if (!empty($input['language']) && !empty($user)) {
            $language = Language::where('locale', $input['language'])->first();
            if (!empty($language)) {
                $user->languages()->sync([$language->id]);
            }
            $user->save();
        }
        if (empty($user)) {
            throw new LoginFailedException('User not exists.');
        }

        if (!$user->is_active) {
            throw new LoginUnAuthorizeException('Your account is not verified.');
        }

        // if (!$user->is_active) {
        //     throw new LoginUnAuthorizeException('Your account is deactivated. please contact your administrator.');
        // }

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
        if (!empty($user->patientDetails)) {
            $data['avatar'] = $user->patientDetails->hasMedia('avatar') ? $user->patientDetails->getMedia('avatar')->first()->getUrl() : '';
        } else {
            $data['avatar'] = '';
        }

        $data['patient_details'] = $user->patientDetails;
        $user->update([
            'login_reactive_time' => null,
            'login_retry_limit' => 0,
        ]);

        return $this->loginSuccess($data);
    }

    public function loginWithBio(Request $request): JsonResponse
    {
        $input = $request->all();
        /** @var User $user */
        $user = User::where('local_auth', $input['local_auth'])->first();

        if (empty($user)) {
            throw new LoginFailedException('User not exists.');
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
        if (!empty($user->patientDetails)) {
            $data['avatar'] = $user->patientDetails->hasMedia('avatar') ? $user->patientDetails->getMedia('avatar')->first()->getUrl() : '';
        } else {
            $data['avatar'] = '';
        }
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
        // $code = rand(100000, 999999);
        $code = 987654;
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
        $user = User::where('phone', $input['phone'])->first();
        if(!$user){
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
        Msg91::send($user->phone, $data['message'] . ' ' . $data['code']);
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
        return sendMsg91OTP($user->country_code . $user->phone, $code) == 'success' ? true : false;
        // $res = Msg91::otp()->to($user->phone)->template('648ae47fd6fc057a7101bb53')->send();
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
        if (!empty($user->patientDetails)) {
            $data['avatar'] = $user->patientDetails->hasMedia('avatar') ? $user->patientDetails->getMedia('avatar')->first()->getUrl() : '';
        } else {
            $data['avatar'] = '';
        }
        $data['patient_details'] = $user->patientDetails;
        return $this->loginSuccess($data);
    }

    public function resendOtp(Request $request)
    {
        $user = User::find(Auth::id());
        $phone = $user->phone;
    }

    public function validateOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|min:6',
            'phone' => 'required| exists:users,phone',
            'type' => 'required|in:register,forgot_password'
        ]);
        try {
            $user = User::where('phone', $request->phone)->first();
            if ($request->type == 'register') {
                if ($user->otp == $request->input('otp')) {
                    $user->is_active = 1;
                    $user->save();
                    $data = $user->toArray();
                    $data['token'] = $user->createToken('Client Login')->plainTextToken;
                    $data['avatar'] = $user->patientDetails->getMedia('avatar')->first()->getUrl();
                    
                    return $this->successResponse($data);
                }
                $user->patientDetails->delete();
                $user->delete();
            }
            if ($request->type == 'forgot_password' && !empty($request->password)) {
                if ($user->reset_password_code == $request->input('otp')) {
                    $user->reset_password_code = null;
                    $user->reset_password_expire_time = null;
                    $user->password = Hash::make($request->password);
                    $user->save();
                    $data = $user->toArray();
                    return $this->successResponse($data);
                }
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
