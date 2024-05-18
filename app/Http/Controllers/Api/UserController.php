<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): Collection
    {
        return UserModel::all();
    }

    public function store(UserRequest $request): JsonResponse
    {
        $user = UserModel::create($request->safe()->all());
        if(empty($user)) {
            return response()->json([
                'success' => false,
                'errors' => 'conflict with request data and current database',
            ], 409);
        }

        return response()->json([
            'success' => 'true',
            'user' => $user,
        ], 201);
    }

    public function show(UserModel $user): JsonResponse
    {
        return response()->json([
            'success' => 'true',
            'user' => $user,
        ]);
    }

    public function update(UserRequest $request, UserModel $user): JsonResponse
    {
        $isUpdated = $user->update($request->safe()->all());

        if(!$isUpdated) {
            return response()->json([
                'success' => false,
                'errors' => 'conflict with request data and current database',
            ], 409);
        }

        return response()->json([
            'success' => 'true',
            'user' => $user,
        ]);
    }

    public function destroy(UserModel $user): JsonResponse
    {
        try{
            $user->delete();
            return response()->json([
                'success' => 'true',
                'message' => 'User Data success deleted'
            ]);
        } catch (QueryException $qe)
        {
            return response()->json([
                'success' => 'false',
                'errors' => $qe->getMessage()
            ], 422);
        }
    }
}
