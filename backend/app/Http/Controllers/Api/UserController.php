<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    public function index(): JsonResponse
    {
        return $this->userServices->listarUsuarios();
    }

    public function show(User $user): JsonResponse
    {
        return $this->userServices->listarUSerEspecifico($user);
    }

    public function store(UserRequest $request): JsonResponse
    {
        return $this->userServices->criarUsuario($request);
    }

    public function update(UserRequest $request, User $user) : JsonResponse
    {
        return $this->userServices->editarUsuario($user, $request);
    }

    public function destroy(User $user): JsonResponse
    {
        return $this->userServices->destroy($user);
    }
}
