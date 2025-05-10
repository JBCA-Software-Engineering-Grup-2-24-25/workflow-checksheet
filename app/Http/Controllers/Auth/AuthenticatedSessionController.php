<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\AppServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $intended = redirect()->getIntendedUrl();

        if ($intended != null) {
            if (str_contains($intended, 'http://')) {
                $intended = str_replace('http://', '', $intended);
            }

            else {
                $intended = str_replace('https://', '', $intended);
            }

            $intended = substr($intended, strpos($intended, '/'));
        }

        else {
            $intended = AppServiceProvider::HOME;
        }

        /** @var User $user */
        $user = Auth::guard('web')->user();

        $user->loadMissing('role.permissions');

        // Cache::tags(['roleUser.' . $user->role_user_id])->add('user.' . $user->id, $user, 60);

        return redirect()->to($intended)->with('status', 'login-success');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
