<?php

namespace App\Controllers\Api\User\Auth;

use App\Services\Auth\LoginService;
use CodeIgniter\RESTful\ResourceController;

class LoginController extends ResourceController
{
  /**
   * Create a new resource object, from "posted" parameters
   *
   * @return mixed
   */
  public function create()
  {
    $req = request()->getJSON();
    $token = (new LoginService)->login($req);

    if (! $token) {
      return $this->failUnauthorized('Invalid username or password!');
    }

    return $this->respond([
      "messages" => "login success",
      // "email" => $data->email,
      "access_token" => $token,
      "token_type" => "Bearer"
    ]);
  }
}
