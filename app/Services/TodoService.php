<?php

namespace App\Services;

use App\Repositories\TodoRepository;

class TodoService
{
  public function __construct(
    private TodoRepository $todoRepository = new TodoRepository
  ) {
  }

  public function findAll()
  {
    return $this->todoRepository->findAll();
  }

  public function findOne($id)
  {
    return $this->todoRepository->findOne($id);
  }

  public function create($request)
  {
    return $this->todoRepository->create($request);
  }

  public function update($id, $data)
  {
    return $this->todoRepository->update($id, $data);
  }

  public function delete($id)
  {
    return $this->todoRepository->delete($id);
  }
}