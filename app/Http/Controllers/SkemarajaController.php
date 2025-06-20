<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Tugas;
use Inertia\Response;
use App\Models\Rekap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SkemarajaController extends Controller
{
    public function index(Request $request): Response
    {
        $user = Auth::user([
            'id',
            'username'
        ]);
        $month = $request->month ?: Carbon::now()->month;
        $year = $request->year ?: Carbon::now()->year;


    $data = Rekap::where('user_id', $user->id)
                ->where('bulan', $month)
                ->where('tahun', $year)
                ->pluck('path');
   


        $date = new \stdClass();
        $date->month = $month;
        $date->year = $year;

        return Inertia::render('skp/Skemaraja', [
            'data' => $data,
            'user' => $user,
            'date' => $date
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string',
        ]);
        $image = $request->file('image');
        $newFileName = $request->name;
        $image->storeAs('absen', $newFileName, 'public');
    }


    public function save(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer',
            'tahun' => 'required|integer',
            'user_id' => 'required|integer',
            'path' => 'required|string',
        ]);

        Rekap::create([
            'user_id' => $request['user_id'],
            'bulan' => $request['bulan'],
            'tahun' => $request['tahun'],
            'path' => $request['path'],
        ]);
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
    public function destroy(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);
        $filePath = "absen/" . $request->path;
        Storage::disk('public')->delete($filePath);
        Rekap::where('path', $request->path)->delete();
    }
}
