<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use App\Models\User;
use App\Services\LoginServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $loginServices;

    public function __construct(LoginServices $loginServices)
    {
        $this->loginServices = $loginServices;
    }
    /* essa e o metodo responsavel pela autenticacao do usuario caso der certo ele demonstra o token e as informacoes
do usuario que foi solicitado mas se der errado ele da uma mensagem falha de login ou senha incorreta

*/
    //retorna a view de login
    public function authView()
    {
        return view('forms.login');
    }
    //retorna a view de regiter
    public function authRegister()
    {
        $generos = Genero::all();
        return view('forms.registrarUser', compact('generos'));
    }

    public function auth(Request $request): JsonResponse
    {
        return $this->loginServices->autenticacao($request);
    }

    // realiza o logout do usuario 
    public function logout(User $user): JsonResponse
    {
        return $this->loginServices->logout($user);
    }
}
