<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $accessFrom = $request->route()->getName();

        if ($accessFrom === 'nasabah.login.show') {
            return view('auth.nasabah-login');
        } else {
            return view('auth.admin-login');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $credentialUsed = $credentials['login'];
        $password = $credentials['password'];
        $rememberMe = $request->has('remember_me');

        // Karena login bisa pake dua field -> no_telepon sama email
        $fieldName = filter_var($credentialUsed, FILTER_VALIDATE_EMAIL) ? 'email' : 'no_telepon';

        $user = $this->checkIfUserExist($fieldName, $credentialUsed);

        $requestFrom = $request->route()->getName();

        // Kalo user login di tempat yang ga sesuai, arahin ke tempat yang sesuai buat mereka login (nasabah/admin)
        if ($requestFrom !== $user->role . '.login.submit') {
            return redirect()
                ->route($user->role . '.login.show')
                ->withErrors(['wrong_route' => 'Silakan login sebagai ' . $user->role]);
        }

        $key = 'login-attempt:' . Str::lower($credentialUsed) . '|' . $request->ip();

        // Maks 5 kali permintaan per-menit, kalo lebih tunggu dulu semenit
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'login' => 'Terlalu banyak permintaan masuk, coba lagi dalam ' . $seconds . ' detik.'
            ]);
        }

        if (!Auth::attempt(
            [
                $fieldName => $credentialUsed,
                'password' => $password
            ],
            $rememberMe
        )) {
            RateLimiter::hit($key, 60);
            throw ValidationException::withMessages([
                'login' => 'Kredensial tidak valid, mohon periksa lagi data Anda.'
            ]);
        }

        RateLimiter::clear($key);

        $request->session()->regenerate();

        return $user->role === 'admin'
            ? redirect()->intended(route('admin.dashboard.index'))
            : redirect()->intended(route('nasabah.dashboard.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function checkIfUserExist(string $field, string $credential)
    {
        $user = User::where($field, $credential)->first();

        if ($user) {
            return $user;
        }

        throw ValidationException::withMessages([
            'login' => 'Kredensial tidak valid, mohon periksa lagi data Anda.'
        ]);
    }
}
