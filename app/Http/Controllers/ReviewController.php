<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Jobs\Robot;
use Inertia\Inertia;
use App\Models\Absen;
use Inertia\Response;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index(): Response
    {

        $staff = Absen::where('tanggal', Carbon::now()->toDateString())
            ->where('status', 1)
            ->with(['user' => function ($query) {
                $query->select('id', 'name');
            }])
            ->get();
        return Inertia::render('absen/Review', [
            'staff' => $staff,
        ]);
    }
    public function active()
    {
        $today = Carbon::now()->toDateString();

        $bots = Absen::where('tanggal', $today)
            ->where('status', 1)
            ->get();

        foreach ($bots as $user) {
            Robot::dispatch($user->nip);
        }
    }
}
