<?php

namespace App\Services;

use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;
use App\Models\User;
use App\Services\Exceptions\UserNotFoundException;
use App\Services\Traits\PagingTrait;
use App\Services\Traits\SortingTrait;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    use SortingTrait;
    use PagingTrait;

    /**
     * @return int
     */
    public function getUserCount(): int
    {
        return User::query()
            ->count();
    }

    /**
     * @param array $withRelations
     * @return Collection|User[]
     */
    public function getUserList(array $withRelations = []): Collection|array
    {
        $query = User::query()
            ->with($withRelations);

        $this->addSorting($query);
        $this->addPaging($query);

        return $query->get();
    }

    /**
     * @param int $userId
     * @param array $withRelations
     * @return User|null
     */
    public function getUserById(int $userId, array $withRelations = []): ?User
    {
        /** @var User $user */
        $user = User::query()
            ->with($withRelations)
            ->find($userId);

        return $user;
    }

    /**
     * @param int $userId
     * @param array $withRelations
     * @return User
     * @throws UserNotFoundException
     */
    public function getUserByIdOrFail(int $userId, array $withRelations = []): User
    {
        return $this->getUserById($userId, $withRelations) ??
            throw new UserNotFoundException("User #{$userId} not found.");
    }

    /**
     * @param string $email
     * @param array $withRelations
     * @return User|null
     */
    public function getUserByEmail(string $email, array $withRelations = []): ?User
    {
        /** @var User $user */
        $user = User::query()
            ->with($withRelations)
            ->where('email', '=', $email)
            ->first();

        return $user;
    }

    /**
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        $user = new User();
        $user->fill($data);
        $user->save();

        UserCreated::dispatch($user);

        return $user;
    }

    /**
     * @param int $userId
     * @param array $data
     * @return User
     * @throws UserNotFoundException
     */
    public function updateUserById(int $userId, array $data): User
    {
        $user = $this->getUserByIdOrFail($userId);
        $data = array_filter($data, fn($v) => $v !== null);

        $user->fill($data);
        $user->save();

        UserUpdated::dispatch($user);

        return $user;
    }

    /**
     * @param int $userId
     * @return User
     * @throws UserNotFoundException
     */
    public function deleteUserById(int $userId): User
    {
        $user = $this->getUserByIdOrFail($userId);
        $user->delete();

        UserDeleted::dispatch($user);

        return $user;
    }
}
