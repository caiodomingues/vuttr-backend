<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\DB;

class TagRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(new Tag());
    }

    public function all($search, $perPage = null)
    {
        $query = app(Tag::class)->newQuery();

        if ($search['name']) {
            $query->where('name', 'like', '%' . strtoupper($search['name']) . '%');
        }

        if ($perPage) {
            return $query->orderBy('id')->paginate($perPage);
        }

        return $query->orderBy('id')->get();
    }

    public function find($id)
    {
        return Tag::findOrFail($id);
    }

    public function save($data, $id = null)
    {
        DB::beginTransaction();
        try {
            $model = ($id) ? $this->find($id) : new Tag();

            $model->fill($data->all());

            $model->save();

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

            $model->delete();

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), null, $e);
        }
    }
}
