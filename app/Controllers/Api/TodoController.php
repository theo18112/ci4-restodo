<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Services\TodoService;
use App\Validations\TodoValidation;
use Throwable;

class TodoController extends ResourceController
{
  public function __construct(
    private TodoService $todoService = new TodoService
  ) {}

  /**
   * Return an array of resource objects, themselves in array format
   *
   * @return mixed
   */
  public function index()
  {
    $todo = $this->todoService->findAll();
    $res = ["data" => $todo];
    return $this->respond($res);
  }

  /**
   * Return the properties of a resource object
   *
   * @return mixed
   */
  public function show($id = null)
  {
    $todo = $this->todoService->findOne($id);
    if (! $todo) {
      return $this->failNotFound('Todo not found!');
    }

    return $this->respond([
      'data' => $todo,
    ]);
  }

  /**
   * Return a new resource object, with default properties
   *
   * @return mixed
   */
  public function new()
  {
    //
  }

  /**
   * Create a new resource object, from "posted" parameters
   *
   * @return mixed
   */
  public function create()
  {
    if (! $this->validate(TodoValidation::rules())) {
      return $this->fail([
        'errors' => $this->validator->getErrors(),
      ]);
    }

    try {
      $this->todoService->create(request()->getJSON());
    } catch (Throwable $exception) {

      return $this->failServerError('Error on create Todo!');
    }

    return $this->respond([
      'message' => 'Todo created successfully!',
    ]);
  }

  /**
   * Return the editable properties of a resource object
   *
   * @return mixed
   */
  public function edit($id = null)
  {
    //
  }

  /**
   * Add or update a model resource, from "posted" properties
   *
   * @return mixed
   */
  public function update($id = null)
  {
    
    if (! $this->validate(TodoValidation::rules())) {
      return $this->fail([
        'errors' => $this->validator->getErrors(),
      ]);
    }
    
    try {
      $this->todoService->update($id, request()->getJSON());
    } catch (Throwable $exception) {
      return $this->failServerError('Error on update Todo!');
    }

    return $this->respond([
      'message' => 'Todo updated successfully!',
    ]);
  }

  /**
   * Delete the designated resource object from the model
   *
   * @return mixed
   */
  public function delete($id = null)
  {
    try {
      $this->todoService->delete($id);
    } catch (Throwable $exception) {

      return $this->failServerError('Error on delete Todo!');
    }

    return $this->respond([
      'message' => 'Todo deleted successfully!',
    ]);
  }
}
