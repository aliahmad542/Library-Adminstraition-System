<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
    public function login_admin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if ($admin->verification_code !== null) {
            return response()->json(['message' => 'Please verify your email first'], 403);
        }

        $token = $admin->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $admin,
        ]);
    }
    public function login_author(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $author = Author::where('email', $request->email)->first();

        if (! $author || !Hash::check($request->password,  $author->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if ( $author->verification_code !== null) {
            return response()->json(['message' => 'Please verify your email first'], 403);
        }

        $token =  $author->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' =>  $author,
        ]);
    }
    public function login_user(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $author = User::where('email', $request->email)->first();

    if (! $author) {
        return response()->json(['message' => 'Email not found'], 404);
    }

    if (!Hash::check($request->password, $author->password)) {
        return response()->json(['message' => 'Wrong password'], 401);
    }

    if ($author->verification_code !== null) {
        return response()->json(['message' => 'Please verify your email first'], 403);
    }

    $token = $author->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
        'user' => $author,
    ]);
}

   
}
