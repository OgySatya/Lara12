<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Tugas;
use Inertia\Response;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function tugas1(Request $request): Response
    {

        $user = Auth::user([
            'id',
            'username'
        ]);
        $month = $request->month ?: Carbon::now()->month;
        $year = $request->input('year') ?: Carbon::now()->year;
        $job_id = Auth::user()->jabatan_id;
        $tugas1 = Tugas::where('jabatan_id', $job_id)->with('target', 'jabatan')->skip(0)->take(1)->first();
        $link = Laporan::where('user_id', $user->id)
            ->where('bulan', $month)
            ->where('tahun', $year)
            ->get();
        $date = new \stdClass();
        $date->month = $month;
        $date->year = $year;
        return Inertia::render('skp/Tugas1', [
            'tugas' => $tugas1,
            'user' => $user,
            'link' => $link,
            'date' => $date
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'link' => 'required|max:225',
            'bulan' => 'required|integer',
            'tahun' => 'required|integer',
            'user_id' => 'required|integer',
            'target_id' => 'required|integer',
        ]);
        Laporan::create([
            'user_id' => $request['user_id'],
            'target_id' => $request['target_id'],
            'bulan' => $request['bulan'],
            'tahun' => $request['tahun'],
            'link' => $request['link'],
        ]);
    }
}
