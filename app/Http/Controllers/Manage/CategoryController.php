<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Helpers\AuthHelper;
use App\Http\Helpers\Pagination;
use App\Http\Requests\CategoryCreateRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $storeId = AuthHelper::getStoreId();

        return Inertia::render('Manage/Categories/Index', [
            'categories' => Pagination::make(
                $this->categoryService->getCategoryCountByStoreId($storeId),
                fn($page, $perPage) => $this->categoryService
                    ->orderBy('name')
                    ->forPage($page, $perPage)
                    ->getCategoryListByStoreId($storeId)
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Manage/Categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryCreateRequest $request): RedirectResponse
    {
        $storeId = AuthHelper::getStoreId();
        $category = $this->categoryService->createCategory($storeId, $request->all());

        return to_route('manage.categories.edit', $category->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): Response
    {
        return Inertia::render('Manage/Categories/Edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->categoryService->updateCategory($category, $request->all());

        return to_route('manage.categories.edit', $category->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $this->categoryService->deleteCategory($category);

        return to_route('manage.categories.index');
    }
}
