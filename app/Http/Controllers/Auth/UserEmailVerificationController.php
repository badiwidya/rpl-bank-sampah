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
        $value = $request->route('value');
        $user = Auth::user();

        if (! URL::hasValidSignature($request)) {
            abort(419, "Invalid or expired link");
        }

        if ($user->id != $userId) {
            abort(403, "Forbidden");
        }

        $isChangeEmail = filter_var($value, FILTER_VALIDATE_EMAIL);

        if ($isChangeEmail) {
            $user->email = $value;
        } else {
            if (hash('sha256', $user->email) != $value) {
                abort (403, "Forbidden");
            }
        }

        $user->email_verified_at = now();

        $user->save();

        return $isChangeEmail === false 
            ? redirect()->route('nasabah.dashboard.index')->with('success', 'Email berhasil diverifikasi')
            : redirect()->route($user->role . '.dashboard.profile')->with('email', 'Berhasil mengganti email');

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
