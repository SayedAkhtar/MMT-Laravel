<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\CreateUserAPIRequest;
use App\Http\Requests\Device\UpdateUserAPIRequest;
use App\Http\Resources\Device\UserResource;
use App\Models\Language;
use App\Models\PatientDetails;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\IsViewModule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function deletePatients(int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->patientDetails()->delete();
            $user->patientFamilyDetails()->delete();
            $user->patientTestimony()->delete();
            $user->patientQuery()->delete();
            $user->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Patient cannot be deleted.');
        }
        return $this->successResponse('Patient deleted successfully.');
    }

    public function listModerators()
    {
        $moderators = User::where('user_type', User::TYPE_HCF)->with('confirmedQuery')->get();
        foreach ($moderators as &$mod) {
            $mod->confirmed_queries = $mod->confirmedQuery->count();
            $mod->completed_queries = 0;
            $mod->confirmedQuery->each(function ($q) use ($mod) {
                $mod->completed_queries += $q->queries?->is_completed ? 1 : 0;
            });
            $mod->pending_queries = $mod->confirmed_queries - ($mod->completed_queries ?? 0);
        }
        return $this->module_view('moderator-list', compact('moderators'));
    }

    public function createModerator()
    {
        $languages = Language::all();
        return $this->module_view('moderator-add', compact('languages'));
    }

    public function storeModerator(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'image' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'language' => 'required',
            'password' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
            $validated['password'] = Hash::make($request->input('password'));
        }
        try {
            $user = User::create(array_merge($validated, ['user_type' => User::TYPE_HCF]));
            if ($user) {
                return redirect(route('moderators.index'))->with('success', "HCF created successfully");
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function editModerator(User $user)
    {
        $languages = Language::all();
        return $this->module_view('moderator-add', compact('user', 'languages'));
    }

    public function updateModerator(Request $request, User $user){
        $validated = $request->validate([
            'name' => 'required',
            'country_code' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'language' => 'required',
            'password' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }
        try {
            $user->update($validated);
            $user->languages()->sync($validated['language']);
            if ($user) {
                return redirect(route('moderators.index'))->with('success', "HCF updated");
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
