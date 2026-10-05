<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
            }
            return redirect()->intended(route('home'))->with('success', 'Berhasil masuk!');
        }

        // Auto-create / sync admin user for local development testing.
        // Catatan: Cukup berikan plain password — model User memiliki cast
        // 'password' => 'hashed' yang akan otomatis melakukan bcrypt.
        if ($request->email === 'admin@lesgo.com' && $request->password === 'admin123') {
            $admin = User::updateOrCreate(
                ['email' => 'admin@lesgo.com'],
                [
                    'name' => 'Admin Lesgo',
                    'password' => 'admin123',
                    'role' => 'admin',
                ]
            );
            Auth::login($admin, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak cocok.',
        ])->onlyInput('email');
    }
}
