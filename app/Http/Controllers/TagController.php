<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Repositories\TagRepository;

class TagController extends Controller
{
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', null);
            $search = ["name" => $request->query('name', null)];

            return TagResource::collection($this->tagRepository->all($search, $perPage));
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error.",
                "message_raw" => $e->getMessage()
            ], 500);
        }
    }

    public function store(TagRequest $request)
    {
        try {
            $model = $this->tagRepository->save($request);

            return response()->json(new TagResource($model), 201);
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
            $model = $this->tagRepository->find($id);

            return new TagResource($model);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error.",
                "message_raw" => $e->getMessage()
            ], 500);
        }
    }

    public function update(TagRequest $request, $id)
    {
        try {
            $model = $this->tagRepository->save($request, $id);

            return new TagResource($model);
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
            $model = $this->tagRepository->delete($id);

            return new TagResource($model);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error.",
                "message_raw" => $e->getMessage()
            ], 500);
        }
    }
}
