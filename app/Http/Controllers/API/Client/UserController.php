<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreateUserAPIRequest;
use App\Http\Requests\Client\CreateUserAPIRequest;
use App\Http\Requests\Client\UpdateUserAPIRequest;
use App\Http\Resources\Client\UserCollection;
use App\Http\Resources\Client\UserResource;
use App\Models\PatientDetails;
use App\Repositories\UserRepository;
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
        DB::beginTransaction();
        try {
            $user = $this->userRepository->update($input, $id);
            $patient = PatientDetails::where('user_id', $user->id)->first();
            if ($patient) {
                $patient->update($input);
            } else {
                $input['user_id'] = $user->id;
                PatientDetails::create($input);
            }
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
                'token' => 'required'
            ]);
            $user = Auth::user();
            $user->firebase_user = $validated['uid'];
            $user->firebase_token = $validated['token'];
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
                $user = PatientDetails::where('user_id', $id)->first();
                $user->updateImage('avatar', 'avatar', false);
            }
            if ($user) {
                return response()->json(["data" => $user], 200);
            } else {
                return response()->json(["STATUS" => "Opps!", "MESSAGE" => "Could not update user. Please try again"], 400);
            }
        } catch (Exception $e) {
            return response()->json(["STATUS" => "Opps!", "MESSAGE" => "Internal server error. Please try again"], 400);
        }
    }

    public function updateBiometric(Request $request)
    {
        $user = Auth::user();
    }
}
