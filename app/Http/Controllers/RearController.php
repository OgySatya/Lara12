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

class JobsController extends Controller
{
    public function jobView(Request $request): Response
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
        return Inertia::render('skp/Rear', [
            'tugas' => $tugas,
            'user' => $user,
            'date' => $date
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'name' => 'required|string',
        ]);
        $image = $request->file('image');
        $newFileName = $request->name;
        $image->storeAs('uploads', $newFileName, 'public');
    }

    public function multiStore(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png',
            'bulan' => 'required|integer',
            'tahun' => 'required|integer',
            'user_id' => 'required|integer',
            'target_id' => 'required|integer',
        ]);

        foreach ($request->file('images') as $file) {
            $newFileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads', $newFileName, 'public');
            Laporan::create([
            'user_id' => $request['user_id'],
            'target_id' => $request['target_id'],
            'bulan' => $request['bulan'],
            'tahun' => $request['tahun'],
            'image' => $newFileName,
        ]);
        }

        return back()->with('success', 'Images uploaded successfully!');
    }

    public function save(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer',
            'tahun' => 'required|integer',
            'user_id' => 'required|integer',
            'target_id' => 'required|integer',
            'image' => 'required|string',
        ]);

        Laporan::create([
            'user_id' => $request['user_id'],
            'target_id' => $request['target_id'],
            'bulan' => $request['bulan'],
            'tahun' => $request['tahun'],
            'image' => $request['image'],
        ]);
    }
    

    public function post(Request $request)
    {
        $post = tugas::findOrFail($request->id);
        $post->update([
            'post' => $request->content,
        ]);
        $id = $request->route;
          // Redirect back to the edit page (same form)
    return redirect()->route('laporan', ['job' => $id])
                     ->with('success', 'Content saved!');
    }
    

    public function destroy(Request $request)
    {
        $request->validate([
            'image' => 'required|string'
        ]);
        $filePath = "uploads/" . $request->image;
        Storage::disk('public')->delete($filePath);
        Laporan::where('image', $request->image)->delete();
    }
}
