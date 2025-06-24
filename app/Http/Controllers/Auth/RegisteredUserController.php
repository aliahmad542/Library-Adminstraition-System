<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Author;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }


    public function register_User(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $verification_code = rand(100000, 999999);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'location' => $request->location,
            'email' => $request->email,
            'verification_code' => $verification_code,
            'password' => Hash::make($request->password),

        ]);

        // Send email
        Mail::raw("Your verification code is: $verification_code", function ($message) use ($user) {
            $message->to($user->email)->subject('Email Verification');
        });

        return response()->json(['message' => 'User registered. Check email for verification code.'], 201);
    }
    public function register_Admin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $verification_code = rand(100000, 999999);

        $user = Admin::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'location' => $request->location,
            'email' => $request->email,
            'verification_code' => $verification_code,
            'password' => Hash::make($request->password),
        ]);

        // Send email
        Mail::raw("Your verification code is: $verification_code", function ($message) use ($user) {
            $message->to($user->email)->subject('Email Verification');
        });

        return response()->json(['message' => 'Admin registered. Check email for verification code.'], 201);
    }
    public function register_Author(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $verification_code = rand(100000, 999999);

        $user = Author::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'location' => $request->location,
            'email' => $request->email,
            'verification_code' => $verification_code,
            'password' => Hash::make($request->password),
        ]);

        // Send email
        Mail::raw("Your verification code is: $verification_code", function ($message) use ($user) {
            $message->to($user->email)->subject('Email Verification');
        });

        return response()->json(['message' => 'Author registered. Check email for verification code.'], 201);
    }
}
