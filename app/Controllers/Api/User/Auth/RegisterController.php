<?php

namespace App\Controllers\Api\User\Auth;

use App\Services\Auth\RegisterService;
use App\Validations\Auth\RegisterValidation;
use CodeIgniter\RESTful\ResourceController;
use Throwable;

class RegisterController extends ResourceController
{
  /**
   * Create a new resource object, from "posted" parameters
   *
   * @return mixed
   */
  public function register()
  {
    if (! $this->validate(RegisterValidation::rules())) {
      return $this->fail([
        'errors' => $this->validator->getErrors(),
      ]);
    }

    try {
      $request = request()->getJSON();
      (new RegisterService)->register($request);
    } catch (Throwable $exception) {
      log_message("error", $exception);

      return $this->failServerError('Error on register user!');
    }

    return $this->respond([
      'message' => 'Registered Successfully!',
    ]);
  }
}
