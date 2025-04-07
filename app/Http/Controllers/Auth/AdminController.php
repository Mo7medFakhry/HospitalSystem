<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\AdminLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {

    }

    public function store(AdminLoginRequest $request)
    {
        if ($request->authenticate()) {

            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::ADMIN);

        } else {

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }



    }

    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
