<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SituacaoRequest;
use App\Models\Situacao;
use App\Services\SituacaoServices;
use Illuminate\Http\JsonResponse;

class SituacaoController extends Controller
{

    protected $situacaoServices;

    public function __construct(SituacaoServices $situacaoServices)
    {
        $this->situacaoServices = $situacaoServices;
    }

    //retorna todas as situacao 
    public function index(): JsonResponse
    {
        return  $this->situacaoServices->listarSituacao();
    }

    //retorna situacao solicitada pelo Id da Url
    public function show(Situacao $situacao): JsonResponse
    {
        return $this->situacaoServices->listarSituacaoId($situacao);
    }

    //criar uma situacao
    public function store(SituacaoRequest $request): JsonResponse
    {
        return $this->situacaoServices->criarSituacao($request);
    }
    //method de editar situacao
    public function update(SituacaoRequest $request, Situacao $situacao): JsonResponse
    {
        return $this->situacaoServices->editarSituacao($situacao, $request);
    }
    //deleta a situacao 
    public function destroy(Situacao $situacao): JsonResponse
    {
        return $this->situacaoServices->deletarSituacao($situacao);
    }
}
