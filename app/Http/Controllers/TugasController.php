<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Tugas;
use Inertia\Response;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TugasController extends Controller
{
    public function tugas(Request $request): Response
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
        return Inertia::render('skp/Tugas', [
            'tugas' => $tugas,
            'user' => $user,
            'date' => $date
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'bulan' => 'required|integer',
            'tahun' => 'required|integer',
            'user_id' => 'required|integer',
            'target_id' => 'required|integer',
            'slug' => 'required|string',
            'username' => 'required|string',
        ]);

        $image = $request->file('image');
        $imageName = time() . '_' . $request['username'] . '_' . $request['slug'] . '.jpg';
        $imageContent = base64_encode(file_get_contents($image->getRealPath()));
        $owner = env('GITHUB_USERNAME');
        $repo = env('GITHUB_REPO');
        $path = "foto/{$imageName}";
        $branch = 'main';
        $token = env('GITHUB_TOKEN');
        $response = Http::withHeaders([
            'Authorization' => "token {$token}",
            'Accept' => 'application/vnd.github.v3+json',
        ])->put("https://api.github.com/repos/{$owner}/{$repo}/contents/{$path}", [
            'message' => "Uploaded {$imageName}",
            'content' => $imageContent,
            'branch' => $branch,
        ]);
        Laporan::create([
            'user_id' => $request['user_id'],
            'target_id' => $request['target_id'],
            'bulan' => $request['bulan'],
            'tahun' => $request['tahun'],
            'image' => $response->json()['content']['download_url'],
        ]);
    }
}
