<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $data = $this->service->all();

            if (!$data) {
                return ApiResponse::error('Nenhum registro encontrado', null, 404);
            }

            return ApiResponse::success($data);

        } catch (\Throwable $e) {
            return ApiResponse::error('Erro interno no servidor', null, 500);
        }
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $data = $this->service->create($request->validated());
            return ApiResponse::success($data);
        } catch (\Throwable $e) {
            return ApiResponse::error('Erro interno no servidor', null, 500);
        }
    }

    public function show($id)
    {
        try {
            $data = $this->service->findById($id);
            return ApiResponse::success($data);
        } catch (\Throwable $e) {
            return ApiResponse::error('Erro interno no servidor', null, 500);
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $data = $this->service->update($id, $request->validated());
            return ApiResponse::success($data);
        } catch (\Throwable $e) {
            return ApiResponse::error('Erro interno no servidor', null, 500);
        }
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return response()->json([
            'message' => 'Registro removido com sucesso.'
        ]);
    }
}
