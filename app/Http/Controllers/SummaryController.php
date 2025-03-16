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

        // Fetch data to be used in the PDF
        $data = [
            'title' => 'Laravel mPDF Example',
            'content' => 'This PDF is generated using a Blade view.',
        ];

        // Load view and convert to HTML
        $html = view('report')->render();

        // Create mPDF instance
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        // Output to browser
        return response($mpdf->Output('document.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }
}
