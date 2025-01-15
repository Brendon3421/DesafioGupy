<?php

namespace App\Services;

use App\DTOs\GeneroDTO;
use App\Http\Requests\GeneroRequest;
use App\Models\Genero;
use Exception;
use Illuminate\Support\Facades\DB;

class GeneroServices
{
    public function listarGenero()
    {
        $generos = Genero::orderby('id', 'DESC')->paginate(3);
        $generoDTOs = GeneroDTO::fromCollection(collect($generos->items()));

        return response()->json([
            'status' => true,
            'generos' => $generoDTOs,
            'message' => 'Generos listados com sucesso'
        ], 200);
    }
    public function listarGeneroId(Genero $genero)
    {
        try {
            $generoDTO = GeneroDTO::fromModel($genero);
            return response()->json([
                'status' => true,
                'genero' => $generoDTO,
                'message' => 'Gênero listado com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function criarGenero(GeneroRequest $request)
    {
        try {
            DB::beginTransaction();
            $genero = Genero::create($request->validated());
            DB::commit();
            $generoDTO = GeneroDTO::fromModel($genero);

            return response()->json([
                'status' => true,
                'genero' => $generoDTO,
                'message' => 'Gênero criado com sucesso',
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar gênero',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function editarGeneroid(Genero $genero, GeneroRequest $request)
    {
        try {
            DB::beginTransaction();
            $genero->update($request->validated());
            DB::commit();
            $generoDTO = GeneroDTO::fromModel($genero);

            return response()->json([
                'status' => true,
                'genero' => $generoDTO,
                'message' => "Gênero editado com sucesso",
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Não foi possível editar o gênero",
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function excluirGenero(Genero $genero)
    {
        try {
            DB::beginTransaction();
            $genero->delete();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => "Gênero excluído com sucesso"
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
