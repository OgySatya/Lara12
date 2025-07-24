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
        // $dayOfyear = Carbon::today()->dayOfYear;
        // $whatDay = $dayOfyear  % 6;   
        // $awal = User::first()->awal;

        // if($awal % 2 !== 0){
        //     $pagiMap = [
        //         [3, 4], // A 2  
        //         [1, 2], // C 3
        //         [1, 2], // C 4
        //         [5, 0], // B 5
        //         [5, 0], // B 0
        //         [3, 4], // A 1
             
        //     ];
        //     $malamMap = [  
        //         [5, 0], // B 0
        //         [3, 4], // A 1
        //         [3, 4], // A 2  
        //         [1, 2], // C 3
        //         [1, 2], // C 4
        //         [5, 0], // B 5
                
        //     ];
        //     $liburMap = [
        //         [1, 2], // C 0
        //         [5, 0], // B 1
        //         [5, 0], // B 2
        //         [3, 4], // A 3
        //         [3, 4], // A 4  
        //         [1, 2], // C 5
        //     ];
        // }else{
        //     $pagiMap = [
        //         [1, 2], // C
        //         [1, 2], // C
        //         [5, 0], // B
        //         [5, 0], // B
        //         [3, 4], // A
        //         [3, 4], // A
             
        //     ];
        //     $malamMap = [  
        //         [3, 4], // A
        //         [3, 4], // A    
        //         [1, 2], // C
        //         [1, 2], // C
        //         [5, 0], // B
        //         [5, 0], // B
        //     ];
        //     $liburMap = [
        //         [5, 0], // B
        //         [5, 0], // B
        //         [3, 4], // A
        //         [3, 4], // A    
        //         [1, 2], // C
        //         [1, 2], // C
        //     ];
        // }
        // $pagi = $pagiMap[$whatDay];
        // $malam = $malamMap[$whatDay];
        // $lepas = $liburMap[$whatDay];

        // $shift1 = User::whereIn('awal', $pagi)
        //             ->where('group', '!=', 'Admin')
        //             ->select('id', 'name', 'status')
        //             ->get();
        
        // $shift2 = User::whereIn('awal', $malam)
        //             ->where('group', '!=', 'Admin')
        //             ->select('id', 'name', 'status', 'awal') 
        //             ->get();
        // $libur = User::whereIn('awal', $lepas)
        //             ->where('group', '!=', 'Admin')
        //             ->select('id', 'name', 'status', 'awal')
        //             ->get();

        // if ($awal % 2 !== 0) {
        //     if ($whatDay % 2 !== 0) {
        //        $shift2a = $shift2;
        //         $shift2b = [];
        //         $libur1 = $libur;
        //     } else {
        //         $shift2a = [];
        //         $shift2b = $shift2;
        //         $libur1 = [];
        //     }
        // } else {
        //     if ($whatDay % 2 === 0) { 
        //         $shift2a = $shift2;
        //         $shift2b = [];
        //         $libur1 = $libur;
        //     } else {
        //         $shift2a = [];
        //         $shift2b = $shift2;
        //         $libur1 = [];
        //     }
        // }
                
    $dayOfYear = Carbon::today()->dayOfYear;
    $whatDay = $dayOfYear % 6;
    $awal = User::first()->awal;
    $isAwalOdd = $awal % 2 !== 0;

    // Define shift maps based on `awal` parity
    $shiftMaps = $isAwalOdd ? [
        'pagi' => [
            [3, 4], [1, 2], [1, 2], [5, 0], [5, 0], [3, 4],
        ],
        'malam' => [
            [5, 0], [3, 4], [3, 4], [1, 2], [1, 2], [5, 0],
        ],
        'libur' => [
            [1, 2], [5, 0], [5, 0], [3, 4], [3, 4], [1, 2],
        ],
    ] : [
        'pagi' => [
            [1, 2], [1, 2], [5, 0], [5, 0], [3, 4], [3, 4],
        ],
        'malam' => [
            [3, 4], [3, 4], [1, 2], [1, 2], [5, 0], [5, 0],
        ],
        'libur' => [
            [5, 0], [5, 0], [3, 4], [3, 4], [1, 2], [1, 2],
        ],
    ];

    // Get groups
    $pagi = $shiftMaps['pagi'][$whatDay];
    $malam = $shiftMaps['malam'][$whatDay];
    $lepas = $shiftMaps['libur'][$whatDay];

    // Fetch users for each group
    $shift1 = User::whereIn('awal', $pagi)->where('group', '!=', 'Admin')->get(['id', 'name', 'status']);
    $shift2 = User::whereIn('awal', $malam)->where('group', '!=', 'Admin')->get(['id', 'name', 'status', 'awal']);
    $libur  = User::whereIn('awal', $lepas)->where('group', '!=', 'Admin')->get(['id', 'name', 'status', 'awal']);

    // Determine shift2 split and libur1
    $isEvenDay = $whatDay % 2 === 0;
    if ($isAwalOdd) {
        $shift2a = !$isEvenDay ? $shift2 : collect();
        $shift2b = $isEvenDay ? $shift2 : collect();
        $libur1  = !$isEvenDay ? $libur : collect();
    } else {
        $shift2a = $isEvenDay ? $shift2 : collect();
        $shift2b = !$isEvenDay ? $shift2 : collect();
        $libur1  = $isEvenDay ? $libur : collect();
    }

        $admin = User::where('group',  'Admin')
        ->select('id', 'name', 'status')            
        ->get();

        $failedJobs = DB::table('failed_jobs')->count();
        return Inertia::render('absen/Review', [
            'dayOfyear' => $dayOfYear,
            'interval' => $whatDay,
            'shift1' => $shift1,
            'shift2a' => $shift2a,
            'shift2b' => $shift2b,
            'libur' => $libur1,
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
    public function clear()
    {
        Artisan::call('queue:flush');
    }
}
