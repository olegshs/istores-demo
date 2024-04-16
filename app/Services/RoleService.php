<?php

namespace App\Services;

use App\Models\Role;
use App\Models\RoleName;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class RoleService
{
    /**
     * @return Collection|Role[]
     */
    public function getRoleList(): Collection|array
    {
        return Role::query()
            ->orderBy('name')
            ->get();
    }

    /**
     * @param string $roleId
     * @return Role|null
     */
    public function getRoleById(int $roleId): ?Role
    {
        /** @var Role $role */
        $role = Role::query()
            ->find($roleId);

        return $role;
    }

    /**
     * @param string $roleName
     * @return Role|null
     */
    public function getRoleByName(RoleName $roleName): ?Role
    {
        /** @var Role $role */
        $role = Role::query()
            ->where('name', '=', $roleName)
            ->first();

        return $role;
    }

    /**
     * @param RoleName $name
     * @param string $description
     * @return Role
     */
    public function createRole(RoleName $name, string $description = ''): Role
    {
        $role = new Role();
        $role->name = $name;
        $role->description = $description;
        $role->save();

        return $role;
    }

    /**
     * @param User $user
     * @return Collection|Role[]
     */
    public function getUserRoles(User $user): Collection|array
    {
        return $user->roles()
            ->orderBy('name')
            ->get();
    }

    /**
     * @param User $user
     * @param array $roleIds
     * @return void
     */
    public function addUserRoles(User $user, array $roleIds): void
    {
        $user->roles()->attach($roleIds);
    }

    /**
     * @param User $user
     * @param array $roleIds
     * @return void
     */
    public function replaceUserRoles(User $user, array $roleIds): void
    {
        $user->roles()->sync($roleIds);
    }

    /**
     * @param User $user
     * @param array $roleIds
     * @return void
     */
    public function deleteUserRoles(User $user, array $roleIds): void
    {
        $user->roles()->detach($roleIds);
    }
}
