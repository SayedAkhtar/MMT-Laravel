<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\CreateUserAPIRequest;
use App\Http\Requests\Device\UpdateUserAPIRequest;
use App\Http\Resources\Device\UserResource;
use App\Models\PatientDetails;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\IsViewModule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Prettus\Validator\Exceptions\ValidatorException;

class UserController extends AppBaseController
{
    use IsViewModule;

    protected $module;
    protected $userModel;
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository, User $userModel)
    {
        $this->userRepository = $userRepository;
        $this->module = "module/user";
        $this->userModel = $userModel;
    }

    /**
     * User's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $users = $this->userRepository->fetch($request);
        return view($this->module . '/index', compact('users'));
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
     * @return UserResource
     * @throws ValidatorException
     *
     */
    public function update(UpdateUserAPIRequest $request, int $id): UserResource
    {
        $input = $request->all();
        if (isset($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }
        $user = $this->userRepository->update($input, $id);

        return new UserResource($user);
    }

    public function delete(int $id): JsonResponse
    {
        $this->userRepository->delete($id);

        return $this->successResponse('User deleted successfully.');
    }

    public function listPatients(Request $request)
    {
        $patients = PatientDetails::with('user', 'specialization')->get();
        return $this->module_view('patient-list', compact('patients'));
    }

    public function listModerators()
    {
        $moderators = [];
        return $this->module_view('moderator-list', compact('moderators'));
    }

    public function createModerators()
    {
        return $this->module_view('moderator-add');
    }
}
