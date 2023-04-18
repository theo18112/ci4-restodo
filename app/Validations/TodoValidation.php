<?php

namespace App\Validations;

class TodoValidation
{
  public static function rules()
  {
    return [
      'user_id' => [
        'rules' => 'required|numeric',
      ],
      'name' => [
        'rules' => 'required|min_length[4]|max_length[255]',
      ],
      'description' => [
        'rules' => 'permit_empty|min_length[4]',
      ],
    ];
  }
}