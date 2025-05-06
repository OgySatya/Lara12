<?php

namespace App\Http\Controllers\Settings;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Requests\Settings\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        $jabatan = Jabatan::all()->select(['id', 'name']);
        return Inertia::render('settings/Profile', [
            'jabatan' => $jabatan
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        $user = User::findOrFail($request->id);
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'NIP' => $request->NIP,
            'jabatan_id' => $request->jabatan,
            'group' => $request->group,
            'password' => Hash::make($request->NIP),
        ]);

        return to_route('profile.edit');
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
