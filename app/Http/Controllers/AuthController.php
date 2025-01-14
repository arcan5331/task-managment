<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        return new LoginResource($user);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);
        if (!Auth::attempt($request->only(['email', 'password']))) {
            Log::info('login for email {email} failed',
                ['email' => $request->input('email')]);

            throw ValidationException::withMessages([
                'form.email' => trans('auth.failed'),
            ]);
        }
        Log::info('user with id {user_id} loged in',
            ['user_id' => auth()->id()]);

        return new LoginResource(auth()->user());
    }

    public function logout(Request $request): Response
    {
        Log::info('user with id {user_id} loged out',
            ['user_id' => auth()->id()]);
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }

}
