<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreateUserAPIRequest;
use App\Http\Requests\Client\CreateUserAPIRequest;
use App\Http\Requests\Client\UpdateUserAPIRequest;
use App\Http\Resources\Client\UserCollection;
use App\Http\Resources\Client\UserResource;
use App\Models\Country;
use App\Models\Language;
use App\Models\PatientDetails;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Prettus\Validator\Exceptions\ValidatorException;

class UserController extends AppBaseController
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * User's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return UserCollection
     */
    public function index(Request $request): UserCollection
    {
        $users = $this->userRepository->fetch($request);

        return new UserCollection($users);
    }

    /**
     * Create User with given payload.
     *
     * @param CreateUserAPIRequest $request
     *
     * @return UserResource
     * @throws ValidatorException
     *
     */
    public function store(CreateUserAPIRequest $request): UserResource
    {
        $input = $request->all();
        if (isset($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }
        $user = $this->userRepository->create($input);

        return new UserResource($user);
    }

    /**
     * Get single User record.
     *
     * @param int $id
     *
     * @return UserResource
     */
    public function show(int $id): UserResource
    {
        $user = $this->userRepository->findOrFail($id);

        return new UserResource($user);
    }

    /**
     * Update User with given payload.
     *
     * @param UpdateUserAPIRequest $request
     * @param int $id
     *
     * @throws ValidatorException
     *
     *
     */
    public function update(UpdateUserAPIRequest $request, int $id)
    {
        $input = $request->all();
        if (isset($input['password']) && $input['old_password']) {
            $input['password'] = Hash::make($input['password']);
        }
        if (empty($input['gender'])) {
            unset($input['gender']);
        }
        DB::beginTransaction();
        try {
            if (!empty($input['country'])) {
                $input['country'] = Country::where('name->en', $input['country'])->first()->id;
            }
            if(!empty($input['dob'])){
                $input['dob'] =  \Carbon\Carbon::createFromFormat('d/m/Y', $input['dob']);
            }
            $user = User::find($id);
            $user->update($input);
            $patient = PatientDetails::where('user_id', $user->id)->first();
            if ($patient) {
                $patient->update($input);
            } else {
                $input['user_id'] = $user->id;
                PatientDetails::create($input);
            }
            // $user = new UserResource($user);
            if (!empty($user->patientDetails)) {
                $user['avatar'] = $user->patientDetails->hasMedia('avatar') ? $user->patientDetails->getMedia('avatar')->first()->getUrl() : '';
            } else {
                $user['avatar'] = [];
            }

            DB::commit();
            if ($user) {
                return $this->successResponse($user);
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
        }
        return $this->errorResponse("Could not update user. Please try again", 400);
    }

    /**
     * Delete given User.
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     *
     */
    public function delete(int $id): JsonResponse
    {
        $this->userRepository->delete($id);

        return $this->successResponse('User deleted successfully.');
    }

    /**
     * Bulk create User's.
     *
     * @param BulkCreateUserAPIRequest $request
     *
     * @return UserCollection
     * @throws ValidatorException
     *
     */
    public function bulkStore(BulkCreateUserAPIRequest $request): UserCollection
    {
        $users = collect();

        $input = $request->get('data');
        foreach ($input as $key => $userInput) {
            $users[$key] = $this->userRepository->create($userInput);
        }

        return new UserCollection($users);
    }

    public function updateFirebase(Request $request)
    {
        try {
            $validated = $request->validate([
                'uid' => 'required',
                'token' => 'required',
                'voip_apn_token' => 'sometimes',
                'device_type' => 'sometimes'
            ]);
            $user = Auth::user();
            $user->firebase_user = $validated['uid'];
            $user->firebase_token = $validated['token'];
            $user->voip_apn_token = $validated['voip_apn_token'];
            $user->device_type = $validated['device_type'];
            if ($user->save()) {
                return $this->successResponse($user);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
        return $this->errorResponse("Internal server error");
    }

    public function updateAvatar(Request $request, int $id)
    {
        try {
            if ($request->hasFile('avatar')) {
                $patient = PatientDetails::with('user')->where('user_id', $id)->first();
                $patient->updateImage('avatar', 'avatar', false);
                $user = $patient->user;
            }
            if ($user) {
                return new UserResource($user);
            } else {
                return response()->json(["STATUS" => "Opps!", "MESSAGE" => "Could not update user. Please try again"], 400);
            }
        } catch (Exception $e) {
            return response()->json(["STATUS" => "Opps!", "MESSAGE" => "Internal server error. Please try again"], 400);
        }
    }

    public function updateLanguage(Request $request)
    {
        try {
            if ($request->has('language')) {
                $user = User::find(Auth::id());
                $language = Language::where('locale', $request->language)->first();
                if (!empty($language)) {
                    $user->languages()->sync([$language->id]);
                }
            }
            return response()->json(["DATA" => $user], 201);
        } catch (\Exception $e) {
            return response()->json(["STATUS" => "Opps!", "MESSAGE" => "Internal server error. Please try again"], 400);
        }
    }

    public function updateBiometric(Request $request)
    {
        $user = Auth::user();
    }
}
