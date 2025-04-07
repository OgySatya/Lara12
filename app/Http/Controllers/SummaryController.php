<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\Tugas;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SummaryController extends Controller
{

    public function show(Request $request)
    {
        $user = Auth::user();
        $job = $request->job ?: 1;
        $month = $request->month ?: Carbon::now()->month;
        $year = $request->year ?: Carbon::now()->year;
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
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
        $date = new \stdClass();
        $date->month = $months[$month];
        $date->year = $year;
        $user->job = $job;
        return view('report', [
            'tugas' => $tugas,
            'user' => $user,
            'date' => $date
        ]);
    }

    public function create(Request $request)
    {
        $user = Auth::user([
            'id',
            'username'
        ]);
        $job = $request->job ?: 1;
        $month = $request->month ?: Carbon::now()->month;
        $year = $request->year ?: Carbon::now()->year;
        $job_id = Auth::user()->jabatan_id;
        $tugas = Tugas::where('jabatan_id', $job_id)->with('target', 'jabatan')->skip($job - 1)->take(1)->first();

        function LaporanImages($userId, $targetId, $month, $year)
        {
            return Laporan::where('user_id', $userId)
                ->where('target_id', $targetId)
                ->where('bulan', $month)
                ->where('tahun', $year)
                ->pluck('image');
        }

        foreach ($tugas->target as $target) {
            $target->laporan = LaporanImages($user->id, $target->id, $month, $year);
        }
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
        $date = new \stdClass();
        $date->month = $months[$month];
        $date->year = $year;
        $user->job = $job;
        ini_set('max_execution_time', 300);

        $html = view('report', [
            'tugas' => $tugas,
            'user' => $user,
            'date' => $date
        ])->render();

        $mpdf = new \Mpdf\Mpdf([
            'margin_top' => 2,
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_bottom' => 15,
        ]);
        $mpdf->AddPage();
        $mpdf->SetMargins(15, 15, 15, 15);
        $mpdf->WriteHTML($html);

        return $mpdf->Output('document.pdf', 'I');
    }
}
