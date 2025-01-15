<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneroRequest;
use App\Models\Genero;
use App\Services\GeneroServices;
use Illuminate\Http\JsonResponse;

class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    protected  $generoServices;

    public function __construct(GeneroServices $generoServices)
    {
        $this->generoServices = $generoServices;
    }

    public function index(): JsonResponse
    {
        return $this->generoServices->listarGenero();
    }


    public function store(GeneroRequest $request): JsonResponse
    {
        return $this->generoServices->criarGenero($request);
    }

    public function update(GeneroRequest $request, Genero $genero): JsonResponse
    {
        return $this->generoServices->criarGenero($request, $genero);
    }


    public function show(Genero $genero): JsonResponse
    {
        return $this->generoServices->listarGeneroId($genero);
    }

    public function destroy(Genero $genero)
    {
        return $this->generoServices->excluirGenero($genero);
    }
}
