<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Pagination;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Services\Exceptions\UserNotFoundException;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    private UserService $userService;
    private RoleService $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function index(): Response
    {
        return Inertia::render('Admin/Users/Index', [
            'users' => Pagination::make(
                $this->userService->getUserCount(),
                fn($page, $perPage) => $this->userService
                    ->orderBy('id')
                    ->forPage($page, $perPage)
                    ->getUserList(['roles'])
            ),
        ]);
    }

    public function edit(int $userId): Response
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $this->userService->getUserById($userId, ['roles']),
            'all_roles' => $this->roleService->getRoleList(),
        ]);
    }

    /**
     * @throws UserNotFoundException
     */
    public function update(int $userId, UserUpdateRequest $request): RedirectResponse
    {
        $this->userService->updateUserById($userId, $request->all());

        return to_route('admin.users.edit', $userId);
    }

    /**
     * @throws UserNotFoundException
     */
    public function destroy(int $userId): RedirectResponse
    {
        $this->userService->deleteUserById($userId);

        return to_route('admin.users.index');
    }
}
