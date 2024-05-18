<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BarangResourceRequest;
use App\Models\BarangModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(): Collection
    {
        return BarangModel::all();
    }

    public function store(BarangResourceRequest $request): JsonResponse
    {
        $barang = BarangModel::create($request->safe()->all());
        if(empty($barang)) {
            return response()->json([
                'success' => false,
                'errors' => 'conflict with request data and current database',
            ], 409);
        }

        return response()->json([
            'success' => 'true',
            'barang' => $barang,
        ], 201);
    }

    public function show(BarangModel $barang): JsonResponse
    {
        return response()->json([
            'success' => 'true',
            'barang' => $barang,
        ]);
    }

    public function update(BarangResourceRequest $request, BarangModel $barang): JsonResponse
    {
        $isUpdated = $barang->update($request->safe()->all());

        if(!$isUpdated) {
            return response()->json([
                'success' => false,
                'errors' => 'conflict with request data and current database',
            ], 409);
        }

        return response()->json([
            'success' => 'true',
            'barang' => $barang,
        ]);
    }

    public function destroy(BarangModel $barang): JsonResponse
    {
        try{
            $barang->delete();
            return response()->json([
                'success' => 'true',
                'message' => 'Barang Data success deleted'
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
