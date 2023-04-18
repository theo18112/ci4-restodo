<?php

namespace App\Validations\Auth;

class RegisterValidation
{
  public static function rules()
  {
    return [
      'username' => [
        'rules' => 'required|min_length[4]|max_length[255]',
      ],
      'email' => [
        'rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[users.email]',
      ],
      'password' => [
        'rules' => 'required|min_length[8]|max_length[255]',
      ],
      'password_confirmation' => [
        'label' => 'confirm password',
        'rules' => 'matches[password]',
      ],
    ];
  }
}