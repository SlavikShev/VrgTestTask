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

    public function deleteModel ($model)
    {
        return $model->delete();
    }

    public function updateModel ($model, $request)
    {
        return $model->update($request->all());
    }

    public function createModel ($request)
    {
        return $this->model::create($request->all());
    }
}
