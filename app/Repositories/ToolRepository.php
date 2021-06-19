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
            // TODO: search tool by tag
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

            foreach ($data->tags as $value) {
                $tag = Tag::where('name', 'LIKE', '%' . $value . '%')->first();
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
