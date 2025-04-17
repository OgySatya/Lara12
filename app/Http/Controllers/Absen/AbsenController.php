<?php

namespace App\Http\Controllers\Absen;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Absen;
use Inertia\Response;
use App\Jobs\SpanUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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

        return Inertia::render('absen/List', [
            'users' => $data,
        ]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'absenId' => 'required|integer|exists:absens,id',
            'tanggal' => 'required|date',
        ]);
    
        $absen = Absen::find($request->absenId);
        $absen->tanggal = $request->tanggal;
        $absen->save();
    
        return back()->with('success', 'Tanggal updated successfully.');
    }
    
}
