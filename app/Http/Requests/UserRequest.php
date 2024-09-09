<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user' => 'required|string|unique:users',
            'name'=>'required|string',
            'email'=>'required',
            'password'=>'required|min:8',
            'confirm_password' => 'required:password|same:password',
            'branch_id'=>'required',
            'department_id'=>'required',
            'role_id'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'user.required' => 'The user name is required.',
            'user.unique' => 'The user name already exists.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password is required.',
            'password.confirmed' => 'The confirmation password does not match.',
        ];
    }
}
