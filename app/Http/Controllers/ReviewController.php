<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Jobs\Robot;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Absen;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function index(): Response
    {
  
        $staff = Absen::where('tanggal', Carbon::now()->toDateString())
        ->where('status', 1)
        ->with(['user' => function ($query) {
            $query->select('id', 'name', 'group');
        }])
        ->get();

        $shift1 = $staff->filter(function ($item) {
            return in_array($item->user->group, ['A', 'B', 'C']) &&
                $item->shift === 1;
        })->values();

        $shift2 = $staff->filter(function ($item) {
            return in_array($item->user->group, ['A', 'B', 'C']) &&
                $item->shift === 2;
        })->values();
        $admin = $staff->filter(function ($item) {
            return $item->user->group === 'Admin' ;
        })->values();


        $failedJobs = DB::table('failed_jobs')->count();
        return Inertia::render('absen/Review', [
            'shift1' => $shift1,
            'shift2' => $shift2,
            'admin' => $admin,
            'failed' => $failedJobs,
        ]);
    }
    public function active()
    {
        $today = Carbon::now()->toDateString();

        $data = Absen::where('tanggal', $today)
            ->where('status', 1)
            ->get();

        foreach ($data as $absen) {
            Robot::dispatch($absen->id);
        }
    }
    public function retry()
    {
        Artisan::call('queue:retry all');
    }
}
