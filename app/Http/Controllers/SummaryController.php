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
        $user = Auth::user([
            'id',
            'username'
        ]);
        $job = $request->tugas ?: 1;
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

        $date = new \stdClass();
        $date->month = $month;
        $date->year = $year;
        $user->job = $job;
        return view('report', [
            'tugas' => $tugas,
            'user' => $user,
            'date' => $date
        ]);
    }

    public function create()
    {

        $html = view('Report')->render();  // This loads the Blade view

        // Create a new instance of mPDF
        $mpdf = new \Mpdf\Mpdf([
            'margin_top' => 2,   // 15mm top margin
            'margin_left' => 10,  // 10mm left margin
            'margin_right' => 10, // 10mm right margin
            'margin_bottom' => 10, // 10mm bottom margin
        ]);

        // Write HTML content to the PDF
        $mpdf->WriteHTML($html);

        // Output PDF (inline in browser or download)
        return $mpdf->Output('document.pdf', 'I');
    }
}
