<?php

namespace App\Repositories;

use App\Models\UserModel;

class UserRepository
{
	public function __construct(private UserModel $userModel = new UserModel) {}

	public function findAll()
	{
		return $this->userModel->findAll();
	}

	public function findOne($id)
	{
		return $this->userModel->find($id);
	}

	public function create($request)
	{
		$db = db_connect();
		$db->transBegin();

		$userId = $this->userModel->insert($request);
		$db->transCommit();

		return $userId;
	}
}