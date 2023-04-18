<?php

namespace App\Repositories;

use App\Models\TodoModel;

class TodoRepository
{
	public function __construct(
		private TodoModel $todoModel = new TodoModel
	) {}

	public function findAll()
	{
		return $this->todoModel->findAll();
	}

	public function findOne($id)
	{
		return $this->todoModel->find($id);
	}

	public function create($request)
	{
		$db = db_connect();
		$db->transBegin();

		$userId = $this->todoModel->insert($request);
		$db->transCommit();

		return $userId;
	}

	public function update($id, $request)
	{
		return $this->todoModel->update($id, $request->getVar());
	}

	public function delete($id)
	{
		return $this->todoModel->delete($id);
	}
}