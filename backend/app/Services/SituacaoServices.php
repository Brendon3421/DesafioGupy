<?php


namespace App\Services;

use App\DTOs\SituacaoDTO;
use App\Http\Requests\SituacaoRequest;
use App\Models\Situacao;
use Exception;
use Illuminate\Support\Facades\DB;

class SituacaoServices
{
    //listar todas as situacoes
    public function listarSituacao()
    {
        $situacao = Situacao::orderby('ID', 'DESC')->paginate(3);

        $situacaoDATA = $situacao->map(function ($situacoes) {
            return SituacaoDTO::fromModel($situacoes)->toArray();
        });

        return response()->json([
            'status' => true,
            'situacao' => $situacaoDATA->toArray(),
            "message" => "Situacoes retornandas com sucesso"
        ], 200);
    }
    //listar situacoes apartir de um id
    public function listarSituacaoId(Situacao $situacao)
    {
        try {
            return response()->json([
                'status' => true,
                'Situacao' => $situacao,
                'message' => "situacao listada com sucesso"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'Error' => $e->getMessage(),
                'message' => 'Situacao  Nao encotrada'
            ], 404);
        }
    }
    //editar situacoes
    public function editarSituacao(Situacao $situacao, SituacaoRequest $request)
    {
        try {
            // Inicia a transação da API
            DB::beginTransaction();
            // Atualiza os dados do modelo existente
            $situacao->fill($request->validated());
            //salva
            $situacao->save();
            //atualiza com forme o model
            $situacaoDTO = SituacaoDTO::makeFromRequest($request, $situacao);

            DB::commit();
            return response()->json([
                'status' => true,
                'situacao' => $situacaoDTO->toArray(),
                'message' => 'Situação atualizada com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Não foi possível atualizar a situação'
            ], 400);
        }
    }

    //criar situacoes
    public function criarSituacao(SituacaoRequest $request)
    {
        try {
            //inicia trasnsicao da api
            DB::beginTransaction();
            //criar a situacao e passa pelas validacao

            $situacaoDTO = SituacaoDTO::makeFromRequest($request);
            $situacaoData = $situacaoDTO->toArray();

            $situacao = Situacao::create($situacaoData);

            DB::commit();
            return response()->json([
                'status' => true,
                'situacao' => $situacao,
                'Message' => 'Situacao cadastrado com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'Error' => $e->getMessage(),
                'Message' => ' Nao foi possivel cadastrar'
            ], 400);
        }
    }
    //deletar situacoes
    public function deletarSituacao(Situacao $situacao)
    {
        try {
            DB::beginTransaction();
            $situacao->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'Situacao deletada' => $situacao,
                'message' => 'Situacao deletado com sucesso'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Nao foi possivel deletar essa situacao',
            ], 400);
        }
    }
}
