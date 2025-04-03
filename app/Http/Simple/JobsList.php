<?php

namespace App\Http\Simple;

use Carbon\Carbon;

use Inertia\Inertia;
use App\Models\Tugas;
use App\Models\Laporan;

use Illuminate\Support\Facades\Auth;

class JobsList
{

    public function Jobs($data)
    {
        $user = Auth::user([
            'id',
            'username'
        ]);
        $job = $data->tugas ?: 1;
        $month = $data->month ?: Carbon::now()->month;
        $year = $data->year ?: Carbon::now()->year;
        $job_id = Auth::user()->jabatan_id;
        $tugas = Tugas::where('jabatan_id', $job_id)->with('target', 'jabatan')->skip($job - 1)->take(1)->first();

        function getLaporanImages($userId, $targetId, $month, $year)
        {
            return Laporan::where('user_id', $userId)
                ->where('target_id', $targetId)
                ->where('bulan', $month)
                ->where('tahun', $year)
                ->pluck('image');
        }

        foreach ($tugas->target as $target) {
            $target->laporan = getLaporanImages($user->id, $target->id, $month, $year);
        }

        $date = new \stdClass();
        $date->month = $month;
        $date->year = $year;
        $user->job = $job;
        return  [
            'tugas' => $tugas,
            'user' => $user,
            'date' => $date
        ];
    }
}
