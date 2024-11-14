<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $allowed_npm = array('55201', '57201', '23201');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'npm'   => ['required', 'string', function ($attribute, $value, $fail) use ($allowed_npm) {
                $npm = substr($value, 2);
                if (!in_array(substr($npm, 0, 5), $allowed_npm)) {
                    $fail('NPM tidak valid, atau tidak diizinkan mendaftar aplikasi ini.');
                }
            }],
        ],
        [
            'email.lowercase' => 'Email harus menggunakan huruf kecil',
            'email.unique' => 'Email sudah terdaftar',
            'email.email' => 'Email tidak valid',
            'email.max' => 'Email maksimal 255 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'npm' => $request->npm,
            'password' => Hash::make($request->password),
        ]);

        // Save the role
        $user->roles()->attach(2); // user role default

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Akun anda berhasil dibuat, silahkan login.');
    }
}
