<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthValidation extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'userName' => 'required',
            'userMail' => 'required|email|unique:users,email',
            'userPass' => 'required|min:6',
            'confPass' => 'required|same:userPass'
        ];
    }

    public function messages()
    {
        return [
            'userName.required' => 'Username is required',
            'userMail.required' => 'Email is required!',
            'userPass.required' => 'Password is required!',
            'userPass.min'      => 'Please enter at least 6 character',
            'confPass.required' => 'Confirm password is required',
            'confPass.same' => 'Confirm password must be match with password',
        ];
    }
}
