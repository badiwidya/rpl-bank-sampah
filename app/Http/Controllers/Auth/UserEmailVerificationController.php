<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\UserVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class UserEmailVerificationController extends Controller
{
    public function notice()
    {
        return view('auth.email-notify');
    }

    public function verify(Request $request)
    {
        $userId = $request->route('id');
        $hashedEmail = $request->route('hash');

        if (! URL::hasValidSignature($request)) {
            abort(419, "Invalid or expired link");
        }

        $user = Auth::user();

        if ($user->id != $userId || hash('sha256', $user->email) != $hashedEmail) {
            abort(403, "Forbidden");
        }

        $user->email_verified_at = now();

        $user->save();

        return redirect()->route('nasabah.dashboard.index'); // OTW

    }

    public function resend(Request $request)
    {
        
        $user = Auth::user();

        $key = 'resend-email:' . $user->id . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 1)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'error' => 'Coba lagi dalam ' . $seconds . ' detik',
            ])->status(429);
        }

        RateLimiter::hit($key, 60);

        $url = $user->generateVerificationUrl();

        $user->notify(new UserVerification($url));

        return back()->with('success', 'Email verifikasi berhasil dikirim ulang.');

    }
}
