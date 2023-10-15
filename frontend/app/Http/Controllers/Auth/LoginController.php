<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Events\Auth\UserLoginSuccess;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login', ['title' => 'Login']);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $email = $request->email;
        $password = $request->password;

        $response = Http::post(env('API_URL').'login', [
            'email' => $email, 
            'password' => $password, 
        ]);

        if($response->failed()) {
            $errors = $response->json()["errors"];
            return back()->withErrors([
                'email' => $errors["login"] ?? null ,
            ])->onlyInput('email');
        }else {
            $data = $response->json()["data"];

            session(['api_token' => $data['token'], 'user' => $data['user']]);
            
            return redirect()->route('home');
        }
        
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $response = Http::withToken(session('api_token'))->post(env('API_URL').'logout');
        session()->forget(['api_token', 'user']);

        if($response->successful()){
            return back();
        }
        
    }
}
