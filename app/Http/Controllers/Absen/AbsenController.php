<?php

namespace App\Http\Controllers\Absen;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AbsenController extends Controller
{
    public function index(): Response
    {
        $users = User::select('NIP', 'name')->get();
        return Inertia::render('absen/List', [
            'users' => $users,
        ]);
    }
    public function run(Request $request)
    {
        $nip = Auth::user()->NIP;


        $scriptPath = base_path('resources\js\pages\absen\bot.js');

        // Run Puppeteer using Node
        $process = new Process(['node', $scriptPath, $nip]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return back()->with('message', 'Bot run complete!');
    }
}
