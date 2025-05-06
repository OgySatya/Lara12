<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Absen;
use Inertia\Response;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        $jabatan = Jabatan::all()->select(['id', 'name']);
        return Inertia::render('auth/Register', [
            'jabatan' => $jabatan
        ]);
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

        for ($i = 0; $i < 10; $i++) {
            Absen::create([
                'user_id' => $user->id,
                'shift' => 1,
                'nip' => $user->NIP,
                'tanggal' => Carbon::now()->toDateString(),
            ]);
        }
        event(new Registered($user));

        Auth::login($user);

        return to_route('login');
    }
}
