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
        $users = User::select('id', 'name')->get();
        $staff = Absen::where('tanggal', Carbon::now()->toDateString())
            ->where('status', 1)
            ->with(['user' => function ($query) {
                $query->select('id', 'name');
            }])
            ->get();
        $failedJobs = DB::table('failed_jobs')->count();
        return Inertia::render('absen/Review', [
            'staff' => $staff,
            'users' => $users,
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
        Artisan::call('queue:retry', ['id' => 'all']);
    }
}
