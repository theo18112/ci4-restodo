<?php

namespace App\Validations;

class TodoValidation
{
  public static function rules()
  {
    return [
      'description' => [
        'rules' => 'required|min_length[4]',
      ],
    ];
  }
}