<?php

namespace App\Services\Auth;

use App\Models\UserModel;
use Firebase\JWT\JWT;

class LoginService
{
	public function login($request)
	{
		if (!$this->checkCredential($request)) {
			return false;
		}

		$key = getenv('CI_JWT_KEY');
		$jwt_algo = getenv('CI_JWT_ALGO');
		$payload = $this->getTokenPayload($request);

		return JWT::encode($payload, $key, $jwt_algo);
	}

	private function checkCredential($request)
	{
		$username = $request->username;
		$password = $request->password;

		$user = (new UserModel)->where('username', $username)->first();

		if (! $user) {
			return false;
		}

		return password_verify($password, $user['password']);
	}

	private function getTokenPayload($request)
	{
		$iat = time();
		$exp = $iat + 3600;

		return [
			'iss' => 'Issuer of the JWT',
			'aud' => 'Audience that the JWT',
			'sub' => 'Subject of the JWT',
			'iat' => $iat,
			'exp' => $exp,
			'email' => $request->username,
		];
	}
}