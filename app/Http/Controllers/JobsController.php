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

class JobsController extends Controller
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
            'bulan' => 'required|integer',
            'tahun' => 'required|integer',
            'user_id' => 'required|integer',
            'target_id' => 'required|integer',
            'slug' => 'required|string',
            'username' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);


        // Get file details
        $file = $request->file('image');
        $filename = time() . '_' . $request['username'] . '_' . $request['slug'] . '.jpg';
        $imageContent = base64_encode(file_get_contents($file->path()));

        // GitHub API details
        $username = env('GITHUB_USERNAME');
        $repo = env('GITHUB_REPO');
        $token = env('GITHUB_TOKEN');
        $path = "foto/" . $filename; // Path in the repo

        // GitHub API URL
        $githubApiUrl = "https://api.github.com/repos/{$username}/{$repo}/contents/{$path}";

        // Upload to GitHub
        $response = Http::withHeaders([
            'Authorization' => "token {$token}",
            'Accept' => 'application/vnd.github.v3+json',
        ])->put($githubApiUrl, [
            'message' => "Uploaded image: {$filename}",
            'content' => $imageContent,
        ]);

        // Check if upload was successful
        if ($response->successful()) {

            Laporan::create([
                'user_id' => $request['user_id'],
                'target_id' => $request['target_id'],
                'bulan' => $request['bulan'],
                'tahun' => $request['tahun'],
                'image' => $response->json()['content']['download_url'],
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'github_url' => $response->json()['content']['download_url'],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image',
                'error' => $response->json(),
            ], 400);
        }
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
