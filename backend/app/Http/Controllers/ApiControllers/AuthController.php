<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('authToken')->plainTextToken;
                $data = ['user' => $user, 'token' => $token];
                $message = 'Login successful.';

                return $this->jsonResponse($data, $message)->cookie(
                    'data', json_encode($data), 180
                );
            }

            $errors = ['login' => 'Invalid email and password combination.'];
            $message = 'Login failed.';

            return $this->jsonResponse(null, $message, $errors, false, 401);
        } catch (Exception $e) {
            return $this->jsonResponse(null, $e->getMessage(), [], false, 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            $message = 'Logout successful.';

            return $this->jsonResponse(null, $message)->withoutCookie('data');
        } catch (Exception $e) {
            return $this->jsonResponse(null, $e->getMessage(), [], false, 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'mobile' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6',
                'c_password' => 'required|same:password',
            ]);

            $name = $request->input('first_name') . ' ' . $request->input('last_name');

            $user = new User([
                'name' => $name,
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'mobile' => $request->input('mobile'),
                'avatar' => 'img/default-avatar.jpg',
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role' => 'user',
            ]);

            $user->save();

            $token = $user->createToken('authToken')->plainTextToken;
            $data = ['user' => $user, 'token' => $token];
            $message = 'Registration successful.';

            return $this->jsonResponse($data, $message, null, true, 201);
        } catch (Exception $e) {
            $errorMessages = $e->getMessage();

            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $validator = $e->validator;
                $errorMessages = $validator->errors()->all();
            }

            return $this->jsonResponse(null, $e->getMessage(), $errorMessages, false, 500);
        }
    }

}



