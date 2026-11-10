<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserAuthenticationController extends Controller
{
    /**
     * Menampilkan halaman formulir login pengguna.
     *
     * @return View|RedirectResponse
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return Auth::user()->isAdministratorRole()
                ? redirect()->route('dashboard.index')
                : redirect()->route('customers.index');
        }

        return view('auth.login');
    }

    /**
     * Memproses verifikasi kredensial login dan membuat sesi pengguna.
     *
     * @param UserLoginRequest $request
     * @return RedirectResponse
     */
    public function authenticateUserCredentials(UserLoginRequest $request): RedirectResponse
    {
        $credentials = [
            'email' => $request->validated('email'),
            'password' => $request->validated('password'),
        ];

        $rememberUserSession = $request->boolean('remember');

        if (Auth::attempt($credentials, $rememberUserSession)) {
            $request->session()->regenerate();

            $targetRoute = Auth::user()->isAdministratorRole()
                ? route('dashboard.index')
                : route('customers.index');

            return redirect()->intended($targetRoute);
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Kombinasi alamat email dan kata sandi tidak sesuai dengan catatan kami.',
            ]);
    }

    /**
     * Mengakhiri sesi aktif pengguna (logout) dan memvalidasi ulang token CSRF.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function terminateUserSession(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
