<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Tugas;
use Inertia\Response;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function tugas1(): Response
    {
        $user = Auth::user([
            'id',
            'username'
        ]);
        $job_id = Auth::user()->jabatan_id;
        $tugas1 = Tugas::where('jabatan_id', $job_id)->with('target', 'jabatan')->skip(0)->take(1)->first();
        return Inertia::render('skp/Tugas1', [
            'tugas' => $tugas1,
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'link' => 'required|max:225',
            'user_id' => 'required|integer',
            'target_id' => 'required|integer',
        ]);
        Laporan::create([
            'user_id' => $request['user_id'],
            'target_id' => $request['target_id'],
            'link' => $request['link'],
            'tanggal' => now(),
        ]);
    }
}
