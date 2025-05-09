<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendChangePasswordEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    public function create()
    {

    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required|string',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()]
        ]);

        $user = $request->user();

        $key = 'change-password:' . $user->email . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'rate_limit' => 'Terlalu banyak permintaan coba lagi dalam ' . $seconds . ' detik.',
            ]);
        }

        if (! Hash::check($validated['old_password'], $user->password)) {
            RateLimiter::hit($key);
            throw ValidationException::withMessages([
                'old_password' => 'Password lama Anda salah'
            ]);
        }

        $user->password = Hash::make($validated['password']);

        $user->save();

        RateLimiter::clear($key);

        SendChangePasswordEmail::dispatch($user);

        return back()->with('success', 'Berhasil mengganti password');
    }
}
