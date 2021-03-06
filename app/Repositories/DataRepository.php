<?php

namespace App\Repositories;

abstract class DataRepository
{
  protected $model;

  public function getCollection()
  {
    return $this->model->all();
  }

  public function getCollectionOrdered()
  {
    return $this->model->orderBy('id', 'desc')->get();
  }

  public function getColumn($column)
  {
    return $this->model->pluck($column);
  }

  public function store($inputs)
  {
    return $this->model->create($inputs);
  }

  public function getByName($name)
  {
    return $this->model->where('name', $name)->first();
  }

  public function getById($id)
  {
    return $this->model->findOrFail($id);
  }

  public function dropForeign($id)
  {
    $this->model->dropForeign($id);
  }

  public function destroy($id)
  {
    return $this->model->findOrFail($id)->delete();
  }

  public function update($input)
  {
    return $this->model->update($input);
  }
}
