<?php

namespace App\Http\Controllers\Absen;

use Carbon\Carbon;

use Inertia\Inertia;
use App\Models\Absen;
use Inertia\Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        $absen = Absen::find($request->absenId);
        $absen->tanggal = Carbon::parse($request->tanggal)->toDateString();
        $absen->status = true;
        $absen->save();

        return back()->with('success', 'Tanggal updated successfully.');
    }
    public function revoke(Request $request)
    {

        $absen = Absen::find($request->absenId);
        $absen->status = false;
        $absen->save();

        return back()->with('success', 'Tanggal updated successfully.');
    }
}
