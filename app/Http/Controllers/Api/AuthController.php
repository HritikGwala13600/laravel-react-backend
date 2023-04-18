<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthValidation as Validation;
use App\Traits\ApiResponse as Response;
use App\Models\User;

class AuthController extends Controller
{
    use Response;


    public function login(Validation $request)
    {
        
    }

    public function register(Validation $request)
    {
        $data = [
            'name' => $request->userName,
            'email' => $request->userMail,
            'profile_image' => 'this is profile',
            'password' => \Hash::make($request->userPass),
        ];
        $user = User::create($data);
        if ($user) {
            return $this->result_ok('Successfully User Created', true, $user->createToken("API Token")->plainTextToken, $data);
        }
        return $this->result_fail('Failed to create user',$data);
    }
}