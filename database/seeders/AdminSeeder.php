<?php

namespace Database\Seeders;

use App\Models\RoleName;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    private UserService $userService;
    private RoleService $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    /**
     * Run the database seeds.
     * @throws \Exception
     */
    public function run(): void
    {
        $adminRoleName = RoleName::Administrator;
        $adminRole = $this->roleService->getRoleByName($adminRoleName);
        if (!$adminRole) {
            throw new \Exception("Role not found: {$adminRoleName->value}");
        }

        $defaultAdmin = $this->userService->createUser([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'admin',
        ]);
        $this->roleService->addUserRoles($defaultAdmin, [$adminRole->id]);
    }
}
