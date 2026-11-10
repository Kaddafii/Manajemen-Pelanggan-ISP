<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserAuthenticationController extends Controller
{
    /**
     * Jumlah maksimum percobaan login yang gagal sebelum akun terkunci sementara.
     */
    protected const MAXIMUM_LOGIN_ATTEMPTS = 5;

    /**
     * Durasi waktu penguncian percobaan login dalam satuan detik (1 menit).
     */
    protected const LOGIN_LOCKOUT_SECONDS = 60;

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
     * Dilengkapi mekanisme pembatasan percobaan login (Rate Limiting).
     *
     * @param UserLoginRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function authenticateUserCredentials(UserLoginRequest $request): RedirectResponse
    {
        // Pastikan pengguna belum melampaui batas percobaan login yang gagal
        $this->ensureLoginAttemptsNotExceeded($request);

        $credentials = [
            'email' => $request->validated('email'),
            'password' => $request->validated('password'),
        ];

        $rememberUserSession = $request->boolean('remember');

        if (Auth::attempt($credentials, $rememberUserSession)) {
            // Bersihkan riwayat percobaan login saat autentikasi berhasil
            RateLimiter::clear($this->resolveLoginThrottleKey($request));

            $request->session()->regenerate();

            $targetRoute = Auth::user()->isAdministratorRole()
                ? route('dashboard.index')
                : route('customers.index');

            return redirect()->intended($targetRoute);
        }

        // Catat kegagalan percobaan login ke dalam rate limiter
        RateLimiter::hit(
            $this->resolveLoginThrottleKey($request), 
            self::LOGIN_LOCKOUT_SECONDS
        );

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Kombinasi alamat email dan kata sandi tidak sesuai dengan catatan kami.',
            ]);
    }

    /**
     * Memastikan percobaan login pengguna belum melampaui batas maksimum yang diizinkan.
     *
     * @param UserLoginRequest $request
     * @return void
     * @throws ValidationException
     */
    protected function ensureLoginAttemptsNotExceeded(UserLoginRequest $request): void
    {
        $throttleKey = $this->resolveLoginThrottleKey($request);

        if (!RateLimiter::tooManyAttempts($throttleKey, self::MAXIMUM_LOGIN_ATTEMPTS)) {
            return;
        }

        $secondsRemaining = RateLimiter::availableIn($throttleKey);

        throw ValidationException::withMessages([
            'email' => "Terlalu banyak percobaan login yang gagal. Silakan coba lagi dalam {$secondsRemaining} detik.",
        ]);
    }

    /**
     * Menghasilkan identifier kunci unik throttle rate limiter berdasarkan email dan IP address klien.
     *
     * @param UserLoginRequest $request
     * @return string
     */
    protected function resolveLoginThrottleKey(UserLoginRequest $request): string
    {
        return Str::transliterate(Str::lower($request->validated('email')) . '|' . $request->ip());
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
