<?php

namespace App\Services\Auth;

use App\Repositories\UserRepository;

class RegisterService
{
  public function register($request)
  {
    return (new UserRepository)->create($request);
  }
}