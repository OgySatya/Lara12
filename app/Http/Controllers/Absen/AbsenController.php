<?php

namespace App\Http\Controllers\Absen;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SpanUser;
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
    public function run()
    {
   
            SpanUser::dispatch('boss');
        
        
    }
}
