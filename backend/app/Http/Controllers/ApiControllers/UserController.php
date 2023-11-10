<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::with('profile')->get();

            $data = [
                'users' => $users,
            ];

            return $this->jsonResponse($data, 'Users retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve users', [$e->getMessage()], false, 500);
        }
    }

    public function show($id)
    {
        try {
            $user = User::with('profile')->find($id);

            if (!$user) {
                return $this->jsonResponse(null, 'User not found', [], false, 404);
            }

            $data = [
                'user' => $user,
            ];

            return $this->jsonResponse($data, 'User retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve the user', [$e->getMessage()], false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->jsonResponse(null, 'User not found', [], false, 404);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'username' => 'nullable|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile' => 'nullable|string',
            'gender' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'avatar' => 'nullable|string',
            'url_website' => 'nullable|string',
            'url_facebook' => 'nullable|string',
            'url_twitter' => 'nullable|string',
            'url_instagram' => 'nullable|string',
            'url_linkedin' => 'nullable|string',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $user->update([
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'gender' => $request->input('gender'),
                'date_of_birth' => $request->input('date_of_birth'),
                'avatar' => $request->input('avatar'),
            ]);

            $profile = $user->profile;
            if ($profile) {
                $profile->update([
                    'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'email' => $request->input('email'),
                    'mobile' => $request->input('mobile'),
                    'gender' => $request->input('gender'),
                    'date_of_birth' => $request->input('date_of_birth'),
                    'avatar' => $request->input('avatar'),
                    'url_website' => $request->input('url_website'),
                    'url_facebook' => $request->input('url_facebook'),
                    'url_twitter' => $request->input('url_twitter'),
                    'url_instagram' => $request->input('url_instagram'),
                    'url_linkedin' => $request->input('url_linkedin'),
                    'address' => $request->input('address'),
                    'bio' => $request->input('bio'),
                ]);
            }

            $data = [
                'user' => $user,
            ];

            return $this->jsonResponse($data, 'User updated successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to update the user', [$e->getMessage()], false, 500);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->jsonResponse(null, 'User not found', [], false, 404);
        }

        try {
            $user->profile()->delete();
            $user->delete();

            return $this->jsonResponse(null, 'User deleted successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to delete the user', [$e->getMessage()], false, 500);
        }
    }
}
