<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;

class LoginServices
{
    public function autenticacao(Request $request)
    {
        // Validar o email e senha
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Recupera os dados do usuário autenticado
            $user = Auth::user();

            // Criar um token para o usuário (exemplo de uso de tokens API)
            $token = $request->user()->createToken('api-token')->plainTextToken;

            // Retorna uma resposta JSON de sucesso com o token e informações do usuário
            return response()->json([
                'status' => true,
                'token' => $token,
                'Usuario' => $user,
                'message' => "Logado com sucesso",
            ], 201);
        } else {
            // Retorna uma resposta JSON de erro se o login falhar
            return response()->json([
                'status' => false,
                'error' => 'Login ou senha incorreta',
            ], 404);
        }
    }

    public function logout(User $user)
    {
        try {
            Auth::logout();
            Session::flush();
            return response()->json([
                'status' => true,
                'nome do usuario' => $user->name,
                'message' => 'Usuário foi desconectado com sucesso',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Usuário não foi desconectado',
            ], 400);
        }
    }
}
