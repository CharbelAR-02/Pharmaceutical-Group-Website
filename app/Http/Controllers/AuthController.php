<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function loginPost(Request $request)
    {


        $validated =  $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]
        );

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $role = $user->role;
            if ($user->role === 'special_employe') {
                return redirect()->route('specialEmploye', $user->id)->with('success', 'Logged in successfully');
            } elseif ($user->role === 'customer' || $user->role === 'pharmacist') {
                return redirect()->route('Customer', $user->id)->with('success', 'Logged in successfully');
            }
            return redirect()->route('home')->with('success', 'Logged in successfully');
        }

        return redirect()->route('home')->with('error', 'Invalid email or password');
    }

    public function registerPost(Request $request)
    {
        $validated =  $request->validate(
            [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'first_name' => 'required|min:2',
                'last_name' => 'required|min:2'
            ]
        );

        $user = User::create(
            [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]
        );

        Customer::create([
            'user_id' => $user->id,
        ]);
        return redirect()->route('login')->with('success', 'Accout created successfully.Proceed to Login');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logged out successfully');
    }
}
