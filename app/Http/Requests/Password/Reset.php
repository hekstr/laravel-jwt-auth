<?php

namespace App\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;

class Reset extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'token' => 'required|max:255|exists:password_resets,token',
      'password' => 'required|confirmed',
    ];
  }
}