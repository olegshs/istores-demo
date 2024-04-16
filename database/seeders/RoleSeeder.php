<?php

namespace Database\Seeders;

use App\Models\RoleName;
use App\Services\RoleService;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->roleService->createRole(
            RoleName::Administrator,
            <<<TEXT
                Administrators can manage users and their stores, add another admins, delete or deactivate stores.
                TEXT
        );
    }
}
