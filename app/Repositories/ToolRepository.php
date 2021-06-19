<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Models\Tool;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\DB;

class ToolRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(new Tool());
    }

    public function all($search, $perPage = null)
    {
        $query = app(Tool::class)->newQuery();

        if ($search['tag']) {
            return Tool::whereHas('tags', function ($query) use ($search) {
                $query->where('name', 'like', '%' . strtoupper($search['tag']) . '%');
            })->paginate($perPage ?? 10);
        }

        if ($perPage) {
            return $query->orderBy('id')->paginate($perPage);
        }

        return $query->orderBy('id')->get();
    }

    public function find($id)
    {
        return Tool::findOrFail($id);
    }

    public function save($data, $id = null)
    {
        DB::beginTransaction();
        try {
            $model = ($id) ? $this->find($id) : new Tool();
            $model->fill($data->all());
            $model->save();

            if ($id) {
                $model->tags()->detach();
            }

            foreach ($data->tags as $value) {
                $tag = Tag::where('name', 'like', '%' . strtoupper($value) . '%')->first();
                $model->tags()->attach([$tag->id]);
            }

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), null, $e);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $model = $this->find($id);

            $model->tags()->detach();

            $model->delete();

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), null, $e);
        }
    }
}
