<?php

namespace Database\Seeders;

use App\Services\CategoryService;
use App\Services\UserService;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private UserService $userService;
    private CategoryService $categoryService;

    private array $categories = [
        'apple@example.com' => [
            [
                'slug' => 'mac',
                'name' => 'Mac',
                'description' => 'If you can dream it, Mac can do it.',
            ],
            [
                'slug' => 'ipad',
                'name' => 'iPad',
                'description' => 'Lovable. Drawable. Magical.',
            ],
            [
                'slug' => 'iphone',
                'name' => 'iPhone',
                'description' => 'Love the power. Love the price.',
            ],
            [
                'slug' => 'watch',
                'name' => 'Watch',
                'description' => 'Smarter. Brighter. Mightier.',
            ],
        ],
        'google@example.com' => [
            [
                'slug' => 'phones',
                'name' => 'Phones',
                'description' => 'Pixel. The only phone engineered by Google.',
            ],
            [
                'slug' => 'earbuds',
                'name' => 'Earbuds',
                'description' => 'Earbuds that sound great all day.',
            ],
            [
                'slug' => 'tablet',
                'name' => 'Tablets',
                'description' => 'The tablet only Google could make.',
            ],
            [
                'slug' => 'watches-trackers',
                'name' => 'Watches & Trackers',
                'description' => 'Smartwatches and trackers to keep you moving.',
            ],
        ],
    ];

    /**
     * @param UserService $userService
     * @param CategoryService $categoryService
     */
    public function __construct(UserService $userService, CategoryService $categoryService)
    {
        $this->userService = $userService;
        $this->categoryService = $categoryService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->categories as $email => $categories) {
            $user = $this->userService->getUserByEmail($email);
            if (!$user) {
                continue;
            }

            foreach ($categories as $category) {
                $this->categoryService->createCategory($user->id, $category);
            }
        }
    }
}
