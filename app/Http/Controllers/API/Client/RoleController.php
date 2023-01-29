<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Client\BulkCreateRoleAPIRequest;
use App\Http\Requests\Client\BulkUpdateRoleAPIRequest;
use App\Http\Requests\Client\CreateRoleAPIRequest;
use App\Http\Requests\Client\UpdateRoleAPIRequest;
use App\Http\Resources\Client\RoleCollection;
use App\Http\Resources\Client\RoleResource;
use App\Repositories\RoleRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class RoleController extends AppBaseController
{
    /**
     * @var RoleRepository
     */
    private RoleRepository $roleRepository;

    /**
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Role's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return RoleCollection
     */
    public function index(Request $request): RoleCollection
    {
        $roles = $this->roleRepository->fetch($request);

        return new RoleCollection($roles);
    }

    /**
     * Create Role with given payload.
     *
     * @param CreateRoleAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return RoleResource
     */
    public function store(CreateRoleAPIRequest $request): RoleResource
    {
        $input = $request->all();
        $role = $this->roleRepository->create($input);

        return new RoleResource($role);
    }

    /**
     * Get single Role record.
     *
     * @param int $id
     *
     * @return RoleResource
     */
    public function show(int $id): RoleResource
    {
        $role = $this->roleRepository->findOrFail($id);

        return new RoleResource($role);
    }

    /**
     * Update Role with given payload.
     *
     * @param UpdateRoleAPIRequest $request
     * @param int                  $id
     *
     * @throws ValidatorException
     *
     * @return RoleResource
     */
    public function update(UpdateRoleAPIRequest $request, int $id): RoleResource
    {
        $input = $request->all();
        $role = $this->roleRepository->update($input, $id);

        return new RoleResource($role);
    }

    /**
     * Delete given Role.
     *
     * @param int $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->roleRepository->delete($id);

        return $this->successResponse('Role deleted successfully.');
    }

    /**
     * Bulk create Role's.
     *
     * @param BulkCreateRoleAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return RoleCollection
     */
    public function bulkStore(BulkCreateRoleAPIRequest $request): RoleCollection
    {
        $roles = collect();

        $input = $request->get('data');
        foreach ($input as $key => $roleInput) {
            $roles[$key] = $this->roleRepository->create($roleInput);
        }

        return new RoleCollection($roles);
    }

    /**
     * Bulk update Role's data.
     *
     * @param BulkUpdateRoleAPIRequest $request
     *
     * @throws ValidatorException
     *
     * @return RoleCollection
     */
    public function bulkUpdate(BulkUpdateRoleAPIRequest $request): RoleCollection
    {
        $roles = collect();

        $input = $request->get('data');
        foreach ($input as $key => $roleInput) {
            $roles[$key] = $this->roleRepository->update($roleInput, $roleInput['id']);
        }

        return new RoleCollection($roles);
    }
}
