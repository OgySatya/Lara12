<?php

namespace App\Http\Controllers\Absen;

use Carbon\Carbon;

use Inertia\Inertia;
use App\Models\Absen;
use Inertia\Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AbsenController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user([
            'id',
            'name'
        ]);
        
        $data['absen'] = Absen::where('user_id', $user->id)->get();
        $data['name'] = $user->name;

        $bot = Absen::where('tanggal', Carbon::now()->toDateString())->where('status', 1)->get();
        return Inertia::render('absen/Absen', [
            'users' => $data,
            'test' => $bot,
        ]);
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'absenId' => 'required|integer|exists:absens,id',
            'shift' => 'required|integer',
            'pagi' => 'required|boolean',
            'malam' => 'required|boolean',
        ]);
   
        $absen = Absen::find($request->absenId)?:  Absen::where('user_id', $request->id)->first();
        $absen->tanggal = Carbon::parse($request->tanggal)->toDateString() ?: Carbon::now()->toDateString();
        $absen->status = true;
        $absen->shift = $request->shift ?: 1;
        $absen->pagi = $validated['pagi'];
        $absen->malam = $validated['malam'];
        $absen->save();

        return back()->with('success', 'Tanggal updated successfully.');
    }
    public function edit(Request $request)
    {

        $absen = User::find($request->absenId);
        $absen->status = $request->status;
        $absen->save();

    }
}
