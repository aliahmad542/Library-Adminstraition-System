<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(
                config('app.frontend_url').'/dashboard?verified=1'
            );
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(
            config('app.frontend_url').'/dashboard?verified=1'
        );
    }



    public function verify_Email_user(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
                    ->where('verification_code', $request->verification_code)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid verification code or email'], 400);
        }

        $user->verification_code = null; // mark as verified
        $user->save();

        return response()->json(['message' => 'Email verified successfully']);
    }
    public function verify_Email_admin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|string',
        ]);

        $user = Admin::where('email', $request->email)
                    ->where('verification_code', $request->verification_code)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid verification code or email'], 400);
        }

        $user->verification_code = null; // mark as verified
        $user->save();

        return response()->json(['message' => 'Email verified successfully']);
    }
    public function verify_Email_author(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|string',
        ]);

        $user = Author::where('email', $request->email)
                    ->where('verification_code', $request->verification_code)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid verification code or email'], 400);
        }

        $user->verification_code = null; // mark as verified
        $user->save();

        return response()->json(['message' => 'Email verified successfully']);
    }








}
