<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        $recaptchaEnabled = Setting::get('recaptcha_enabled', config('services.recaptcha.enabled', '0'));
        $recaptchaSiteKey = Setting::get('recaptcha_site_key', config('services.recaptcha.site_key', ''));
        $recaptchaSecretKey = Setting::get('recaptcha_secret_key', config('services.recaptcha.secret_key', ''));

        $isRecaptchaActive = ($recaptchaEnabled == '1' || $recaptchaEnabled === true) 
                             && !empty($recaptchaSiteKey) 
                             && !empty($recaptchaSecretKey);

        return view('admin.auth.login', compact('isRecaptchaActive', 'recaptchaSiteKey'));
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        $recaptchaEnabled = Setting::get('recaptcha_enabled', config('services.recaptcha.enabled', '0'));
        $recaptchaSiteKey = Setting::get('recaptcha_site_key', config('services.recaptcha.site_key', ''));
        $recaptchaSecretKey = Setting::get('recaptcha_secret_key', config('services.recaptcha.secret_key', ''));

        $isRecaptchaActive = ($recaptchaEnabled == '1' || $recaptchaEnabled === true) 
                             && !empty($recaptchaSiteKey) 
                             && !empty($recaptchaSecretKey);

        if ($isRecaptchaActive) {
            $recaptchaToken = $request->input('g-recaptcha-response');
            
            if (!empty($recaptchaToken)) {
                try {
                    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                        'secret' => $recaptchaSecretKey,
                        'response' => $recaptchaToken,
                        'remoteip' => $request->ip(),
                    ]);

                    $responseData = $response->json();
                    $isSuccess = $responseData['success'] ?? false;
                    $score = $responseData['score'] ?? 0.0;

                    if (!$isSuccess || $score < 0.3) {
                        return back()->withErrors([
                            'email' => 'Güvenlik doğrulaması şüpheli aktivite tespit etti (Skor: ' . $score . '). Lütfen tekrar deneyiniz.',
                        ])->onlyInput('email');
                    }
                } catch (\Exception $e) {
                    // Fallback gracefully on timeout/network issue
                }
            }
        }

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Girdiğiniz e-posta veya şifre hatalı.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
