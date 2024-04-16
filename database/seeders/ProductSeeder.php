<?php

namespace Database\Seeders;

use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\UserService;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    private UserService $userService;
    private CategoryService $categoryService;
    private ProductService $productService;

    private array $products = [
        'apple@example.com' => [
            'mac' => [
                [
                    'slug' => 'apple-macbook-air-m1',
                    'name' => 'לחצו על מנת להרכיב Apple MacBook Air (M1) מקבוק אייר עם מעבד M1 שמתאים לכם',
                    'description' => <<<TEXT
                        מגוון מחשבי Apple MacBook Air 13 בדגמים, צבעים, נפחים שונים ועוד. לחצו על מנת להרכיב את ה-MacBook המתאים לכם!!
                        TEXT,
                    'price' => 3499,
                ],
                [
                    'slug' => 'apple-14-inch-macbook-pro-m3',
                    'name' => 'לחצו על מנת להרכיב 2023 Apple 14-inch MacBook Pro M3 שמתאים לכם',
                    'description' => <<<TEXT
                        לחצו על מנת להרכיב 2023 Apple 14-inch MacBook Pro M3 שמתאים לכם.
                        TEXT,
                    'price' => 7249,
                ],
            ],
            'ipad' => [],
            'iphone' => [
                [
                    'slug' => 'apple-iphone-15-128gb',
                    'name' => 'אייפון Apple iPhone 15 128GB - צבע שחור - שנה אחריות יבואן רשמי - ללא מטען וללא אוזניות',
                    'description' => <<<TEXT
                        iPhone 15 העוצמתי מבית Apple, בעל מסך 6.1 אינטש Super Retina XDR OLED, עם חיישן זיהוי פנים, מעבד ראשי A16 Bionic, זוג מצלמות אחוריות אחת עם 48MP והשנייה 12MP, מצלמת סלפי 12MP, אפשרות טעינה אלחוטית ותמיכה ברשת הדור החמישי 5G.
                        TEXT,
                    'price' => 3389,
                ],
                [
                    'slug' => 'apple-iphone-15-pro-max-256gb',
                    'name' => 'אייפון Apple iPhone 15 Pro Max 256GB - צבע טיטניום טבעי - שנה אחריות יבואן רשמי - ללא מטען וללא אוזניות',
                    'description' => <<<TEXT
                        iPhone 15 Pro Max העוצמתי מבית Apple, בעל מסך 6.7 אינטש Super Retina XDR, עם חיישן זיהוי פנים, מעבד ראשי A17 Pro עוצמתי, שלוש מצלמות אחוריות 48+12+12 מגה פיקסל, מצלמת סלפי 12 מגה פיקסל, אפשרות טעינה אלחוטית ותמיכה ברשת הדור החמישי 5G.
                        TEXT,
                    'price' => 5599,
                ],
                [
                    'slug' => 'apple-iphone-13-128gb',
                    'name' => 'אייפון Apple iPhone 13 128GB - צבע Starlight - שנה אחריות יבואן רשמי - ללא מטען וללא אוזניות',
                    'description' => <<<TEXT
                        האייפון 13 החזק והעוצמתי מבית Apple, בעל מסך 6.1 אינטש Super Retina XDR OLED, עם חיישן זיהוי פנים, מעבד ראשי A15 Bionic, שתי מצלמות אחוריות 12 מגה פיקסל, מצלמת סלפי 12 מגה פיקסל, עם אפשרות טעינה אלחוטית ותמיכה ברשת הדור החמישי 5G.
                        TEXT,
                    'price' => 2549,
                ],
            ],
            'watch' => [],
        ],
        'google@example.com' => [
            'phones' => [
                [
                    'slug' => 'google-pixel-7-8gb-256gb',
                    'name' => 'טלפון סלולרי Google Pixel 7 8GB+256GB - צבע Obsidian - שנה אחריות',
                    'description' => <<<TEXT
                        סמארטפון איכותי מבית Google, בעל מסך בגודל 6.3'', זוג מצלמות 50+12 מגה פיקסל, מצלמת סלפי 10.8 מגה פיקסל, חיישן טביעת אצבע, ערכת שבבים בעלת 8 ליבות, מערכת הפעלה אנדרואיד מתקדמת.
                        TEXT,
                    'price' => 2049,
                ],
                [
                    'slug' => 'google-pixel-7-pro-12gb-256gb',
                    'name' => 'טלפון סלולרי Google Pixel 7 Pro 12GB+256GB - צבע Hazel - שנה אחריות',
                    'description' => <<<TEXT
                        סמארטפון איכותי מבית Google, בעל מסך בגודל 6.7'', שלוש מצלמות 50+48+12 מגה פיקסל, מצלמת סלפי 10.8 מגה פיקסל, חיישן טביעת אצבע, ערכת שבבים בעלת 8 ליבות, מערכת הפעלה אנדרואיד מתקדמת.
                        TEXT,
                    'price' => 3099,
                ],
                [
                    'slug' => 'google-pixel-fold-12gb-256gb',
                    'name' => 'טלפון סלולרי Google Pixel Fold 12GB+256GB - צבע Porcelain - שנה אחריות',
                    'description' => <<<TEXT
                        סמארטפון איכותי מבית Google, בעל מסך בגודל 6.3'', זוג מצלמות 50+12 מגה פיקסל, מצלמת סלפי 10.8 מגה פיקסל, חיישן טביעת אצבע, ערכת שבבים בעלת 8 ליבות, מערכת הפעלה אנדרואיד מתקדמת.
                        TEXT,
                    'price' => 6149,
                ],
            ],
            'earbuds' => [],
            'tablet' => [],
            'watches-trackers' => [],
        ],
    ];

    /**
     * @param UserService $userService
     * @param CategoryService $categoryService
     * @param ProductService $productService
     */
    public function __construct(UserService $userService, CategoryService $categoryService, ProductService $productService)
    {
        $this->userService = $userService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->products as $email => $categories) {
            $user = $this->userService->getUserByEmail($email);
            if (!$user) {
                continue;
            }

            foreach ($categories as $slug => $products) {
                $category = $this->categoryService->getCategoryByStoreIdAndSlug($user->id, $slug);
                if (!$category) {
                    continue;
                }

                foreach ($products as $productData) {
                    $product = $this->productService->createProduct($user->id, $productData);
                    $this->productService->addProductCategories($product, [$category->id]);
                }
            }
        }
    }
}
