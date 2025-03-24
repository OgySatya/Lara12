<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisterJobController extends Controller
{

    public function create(): Response
    {

        return Inertia::render('auth/NewJob', []);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'NIP' => 'required|integer',
            'jabatan' => 'required|integer',
            'group' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'NIP' => $request->NIP,
            'jabatan_id' => $request->jabatan,
            'group' => $request->group,
            'password' => Hash::make($request->NIP),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return to_route('login');
    }
}
