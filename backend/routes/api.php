<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GeneroController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\SituacaoController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
//rotas situacao
Route::get('/situacao', [SituacaoController::class, 'index']); //get http://127.0.0.1:8000/api/situacao/ , exibe conteudo das situacao 
Route::get('/situacao/{situacao}', [SituacaoController::class, 'show']); //get http://127.0.0.1:8000/api/situacao/{situacao}, exibe conteudo da situacao especifico do numero da url 
Route::post('/situacao', [SituacaoController::class, 'store']);  //get http://127.0.0.1:8000/api/situacao/ , cria uma situacao 
Route::put('/situacao/{situacao}', [SituacaoController::class, 'update']);  //get http://127.0.0.1:8000/api/situacao/{sistuacao} ,  edita um endereco solicitado 
Route::delete('/situacao/{situacao}', [SituacaoController::class, 'destroy']); //delete  http://127.0.0.1:8000/api/users/1 , deletar  usuario especifico
//rotas Usuario
Route::get('/users', [UserController::class, 'index']); //get http://127.0.0.1:8000/api/users?page=1 exibe conteudo de  todos os usuarios 
Route::get('/users/{user}', [UserController::class, 'show']); //get http://127.0.0.1:8000/api/users/1 , exibe conteudo de um usuario especifico
Route::post('/users', [UserController::class, 'store']); //post - http://127.0.0.1:8000/api/users criar usuario
Route::put('/users/{user}', [UserController::class, 'update']); //put  http://127.0.0.1:8000/api/users/1 , edita conteudo de um usuario especifico
Route::delete('/users/{user}', [UserController::class, 'destroy']); //delete  http://127.0.0.1:8000/api/users/1 , deletar  usuario especifico
route::post('/login', [LoginController::class, 'auth'])->name('login'); // http://127.0.0.1:8000/api/login/{information users} , rota publica de login do usuario ao sistema
//rotas do genero
Route::get('/genero', [GeneroController::class, 'index'])->name('genero'); //get http://127.0.0.1:8000/api/genero/ , exibe conteudo dos generos cadastrados
Route::post('/genero', [GeneroController::class, 'store']); //post http://127.0.0.1:8000/api/genero/ , cria um genero
Route::put('/genero/{genero}', [GeneroController::class, 'update']); //post http://127.0.0.1:8000/api/genero/{genero} edit
Route::get('/genero/{genero}', [GeneroController::class, 'show']); //get http://127.0.0.1:8000/api/genero/{genero} puxa genero com o id solicitado
Route::delete('/genero/{genero}', [GeneroController::class, 'destroy']); //get http://127.0.0.1:8000/api/genero/{genero} puxa genero com o id solicitado
//rotas do Categoria
Route::get('/categoria', [CategoryController::class, 'index']); //get http://127.0.0.1:8000/api/genero/ , exibe conteudo dos generos cadastrados
Route::post('/categoria', [CategoryController::class, 'store']); //post http://127.0.0.1:8000/api/genero/ , cria um genero
Route::put('/categoria/{categoria}', [CategoryController::class, 'update']); //post http://127.0.0.1:8000/api/genero/{genero} edit
Route::get('/categoria/{categoria}', [CategoryController::class, 'show']); //get http://127.0.0.1:8000/api/genero/{genero} puxa genero com o id solicitado
Route::delete('/categoria/{categoria}', [CategoryController::class, 'destroy']); //get http://127.0.0.1:8000/api/genero/{genero} puxa genero com o id solicitado



// rotas que sao necessarios os tokens de autenticacao 
Route::post('/logout/{user}', [LoginController::class, 'logout'])->name('logout'); //rota de logout do usuario
route::group(['middleware' => ['auth:sanctum']], function () {
    //rotas da task
    Route::get('/task', [TaskController::class, 'index']); //get http://127.0.0.1:8000/api/task/ lista todas as task
    Route::get('/task/{task}', [TaskController::class, 'show']); //get http://127.0.0.1:8000/api/task/{task} lista a task com o id passado na url
    Route::post('/task', [TaskController::class, 'store']); //post http://127.0.0.1:8000/api/task/{task} cria uma task 
    Route::put('/task/{task}', [TaskController::class, 'update']); //put http://127.0.0.1:8000/api/task/{task} editar a task
    Route::delete('/task/{task}', [TaskController::class, 'destroy']); //delete http://127.0.0.1:8000/api/task/{task} deletar a task

});
