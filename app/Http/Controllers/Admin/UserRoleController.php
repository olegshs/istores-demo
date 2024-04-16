<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRoleUpdateRequest;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserRoleController extends Controller
{
    private UserService $userService;
    private RoleService $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function index(int $userId): JsonResponse
    {
        $user = $this->getUser($userId);

        $roles = $this->roleService->getUserRoles($user);
        return response()->json($roles);
    }

    public function store(int $userId, UserRoleUpdateRequest $request): JsonResponse
    {
        $user = $this->getUser($userId);

        $roleIds = $request->input('role_ids');
        $this->roleService->addUserRoles($user, $roleIds);

        $roles = $this->roleService->getUserRoles($user);
        return response()->json($roles);
    }

    public function update(int $userId, UserRoleUpdateRequest $request): JsonResponse
    {
        $user = $this->getUser($userId);

        $roleIds = $request->input('role_ids');
        $this->roleService->replaceUserRoles($user, $roleIds);

        $roles = $this->roleService->getUserRoles($user);
        return response()->json($roles);
    }

    public function destroy(int $userId, UserRoleUpdateRequest $request): JsonResponse
    {
        $user = $this->getUser($userId);

        $roleIds = $request->input('role_ids');
        $this->roleService->deleteUserRoles($user, $roleIds);

        $roles = $this->roleService->getUserRoles($user);
        return response()->json($roles);
    }

    private function getUser(int $userId): User
    {
        $user = $this->userService->getUserById($userId);
        if (!$user) {
            abort(Response::HTTP_NOT_FOUND, "User #{$userId} not found.");
        }

        return $user;
    }
}
