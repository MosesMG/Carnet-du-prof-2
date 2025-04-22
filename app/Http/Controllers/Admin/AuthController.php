<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password as NewPassword;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', Password::min(6)],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
    
            $request->session()->regenerate();
            
            return redirect()->intended(route('admin.accueil'));
        }
        
        return back()->with(
            'message', 'Identifiants incorrects ou compte inexistant'
        );
    }

    public function register(): View
    {
        return view('auth.register');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.Admin::class,
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.accueil');
    }

    public function forgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function submitEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        $status = NewPassword::broker('admins')->sendResetLink(
            $request->only('email')
        );

        if ($status === NewPassword::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    public function newPassword(Request $request): View
    {
        return view('auth.password-reset', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    public function submitPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $status = NewPassword::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($admin, $password) {
                $admin->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
    
                event(new PasswordReset($admin));
            }
        );

        if ($status == NewPassword::PASSWORD_RESET) {
            return redirect()->route('admin.login')->with('status', __($status));
        }

        return back()->withErrors([
            'email' => trans($status)
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
