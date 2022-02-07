<?php

namespace App\Repositories;

abstract class CoreRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    abstract protected function getModelClass ();

    public function deleteModel ($author)
    {
        return $author->delete();
    }

    public function updateModel ($author, $request)
    {
        return $author->update($request->all());
    }

    public function createModel ($request)
    {
        return $this->model::create($request->all());
    }
}
