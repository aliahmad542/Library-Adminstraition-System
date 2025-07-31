<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Author;

use Symfony\Component\HttpFoundation\Response;

class AdminOrAuthorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
     {
       $user = Auth::user();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $email = $user->email;

    $isAdmin = Admin::where('email', $email)->exists();
    $isAuthor = Author::where('email', $email)->exists();

    if (!$isAdmin && !$isAuthor) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    return $next($request);
    }}
