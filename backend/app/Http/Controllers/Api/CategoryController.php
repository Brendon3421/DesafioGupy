<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected  $categoryServices;

    public function __construct(CategoryServices $categoryServices)
    {
        $this->categoryServices = $categoryServices;
    }

    public function index(): JsonResponse
    {
        return $this->categoryServices->getCategory();
    }


    public function store(CategoryRequest $request): JsonResponse
    {
        return $this->categoryServices->criarCategory($request);
    }

    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        return $this->categoryServices->editarCategoryId($category, $request);
    }


    public function show(Category $category): JsonResponse
    {
        return $this->categoryServices->listarCategoriaId($category);
    }

    public function destroy(Category $category)
    {
        return $this->categoryServices->excluirCategory($category);
    }
}
