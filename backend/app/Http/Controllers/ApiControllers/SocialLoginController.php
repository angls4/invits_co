<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SocialLoginController extends Controller
{
    /**
     * Obtain the user information from Provider (Facebook, Google, GitHub...).
     *
     * 
     */
    public function handleProvider(Request $request, $provider)
    {
        try {
            $socialUser = $request;

            if (!$socialUser) {
                throw new Exception('Failed to fetch user data from the social provider.');
            }

            $authUser = $this->findOrCreateUser($socialUser, $provider);

            Auth::login($authUser, true);

            $token = $authUser->createToken('authToken')->plainTextToken;
            $data = ['user' => $authUser, 'token' => $token];
            $message = 'Login successful.';

            return $this->jsonResponse($data, $message)->cookie(
                'data', json_encode($data), 180
            );
        } catch (Exception $e) {
            return $this->jsonResponse(null, $e->getMessage(), [], false, 500);
        }
    }

    /**
     * Return user if exists; create and return if doesn't.
     *
     * @param $githubUser
     * @return User
     */
    private function findOrCreateUser($socialUser, $provider)
    {
        if ($authUser = UserProvider::where('provider_id', $socialUser->id)->first()) {
            $authUser = User::findOrFail($authUser->user->id);

            return $authUser;
        } elseif ($authUser = User::where('email', $socialUser->email)->first()) {
            UserProvider::create([
                'user_id'     => $authUser->id,
                'provider_id' => $socialUser->id,
                'avatar'      => 'img/default-avatar.jpg',
                'provider'    => $provider,
            ]);

            return $authUser;
        } else {
            $name = $socialUser->name;

            $name_parts = $this->split_name($name);
            $first_name = $name_parts[0];
            $last_name = $name_parts[1];
            $email = $socialUser->email;

            if ($email == '') {
                Log::error('Social Login does not have email!');

                $errors = ['email' => 'Social Login does not have email!'];
                $message = 'Login failed.';

                return $this->jsonResponse(null, $message, $errors, false, 401);
            }

            $user = User::create([
                'first_name'  => $first_name,
                'last_name'   => $last_name,
                'name'        => $name,
                'email'       => $email,
                'avatar'      => 'img/default-avatar.jpg',
                'role'        => 'user',
            ]);

            // $media = $user->addMediaFromUrl($socialUser->getAvatar())->toMediaCollection('users');
            // $user->avatar = $media->getUrl();
            // $user->save();

            UserProvider::create([
                'user_id'     => $user->id,
                'provider_id' => $socialUser->id,
                'avatar'      => 'img/default-avatar.jpg',
                'provider'    => $provider,
            ]);

            return $user;
        }
    }

    /**
     * Split Name into first name and last name.
     */
    public function split_name($name)
    {
        $name = trim($name);

        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#'.$last_name.'#', '', $name));

        return [$first_name, $last_name];
    }
}
