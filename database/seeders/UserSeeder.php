<?php

namespace Database\Seeders;

use App\Services\UserService;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->userService->createUser([
            'name' => 'Apple',
            'email' => 'apple@example.com',
            'password' => 'test',
        ]);

        $this->userService->createUser([
            'name' => 'Google',
            'email' => 'google@example.com',
            'password' => 'test',
        ]);

        $this->userService->createUser([
            'name' => 'Samsung',
            'email' => 'samsung@example.com',
            'password' => 'test',
        ]);
    }
}
