<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ToolRequest;
use App\Http\Resources\ToolResource;
use App\Repositories\ToolRepository;

class ToolController extends Controller
{
    private $toolRepository;

    public function __construct(ToolRepository $toolRepository)
    {
        $this->toolRepository = $toolRepository;
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', null);
            $search = ["tag" => $request->query('tag', null)];

            return ToolResource::collection($this->toolRepository->all($search, $perPage));
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error.",
                "message_raw" => $e->getMessage()
            ], 500);
        }
    }

    public function store(ToolRequest $request)
    {
        try {
            $model = $this->toolRepository->save($request);

            return response()->json(new ToolResource($model), 201);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error.",
                "message_raw" => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $model = $this->toolRepository->find($id);

            return new ToolResource($model);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error.",
                "message_raw" => $e->getMessage()
            ], 500);
        }
    }

    public function update(ToolRequest $request, $id)
    {
        try {
            $model = $this->toolRepository->save($request, $id);

            return new ToolResource($model);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error.",
                "message_raw" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->toolRepository->delete($id);

            return response(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error.",
                "message_raw" => $e->getMessage()
            ], 500);
        }
    }
}
