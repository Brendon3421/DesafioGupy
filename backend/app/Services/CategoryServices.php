<?php

namespace App\Services;

use App\DTOs\CategoryDTO;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;

class CategoryServices
{
    /**
     * Listar todas as categorias com paginação.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategory()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(5);

        return response()->json([
            'status' => true,
            'categorias' => $categories,
            'message' => 'Categorias listadas com sucesso',
        ], 200);
    }

    /**
     * Obter detalhes de uma categoria pelo ID.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function listarCategoriaId(Category $category)
    {
        return response()->json([
            'status' => true,
            'categoria' => $category->toArray(),
            'message' => 'Categoria listada com sucesso',
        ], 200);
    }

    /**
     * Criar uma nova categoria.
     *
     * @param  CategoryRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function criarCategory(CategoryRequest $request)
    {
        DB::beginTransaction();

        try {
            $category = Category::create($request->validated());
            DB::commit();

            $categoryDTO = CategoryDTO::fromModel($category);

            return response()->json([
                'status' => true,
                'categoria' => $categoryDTO,
                'message' => 'Categoria criada com sucesso',
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar categoria',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Editar uma categoria existente.
     *
     * @param  Category  $category
     * @param  CategoryRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editarCategoryId(Category $category, CategoryRequest $request)
    {
        DB::beginTransaction();

        try {
            $category->update($request->validated());
            DB::commit();

            $categoryDTO = CategoryDTO::fromModel($category);

            return response()->json([
                'status' => true,
                'categoria' => $categoryDTO,
                'message' => 'Categoria editada com sucesso',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Erro ao editar categoria',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Excluir uma categoria.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function excluirCategory(Category $category)
    {
        DB::beginTransaction();

        try {
            $category->delete();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Categoria excluída com sucesso',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Erro ao excluir categoria',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
