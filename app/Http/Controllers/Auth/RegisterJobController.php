<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Tugas;
use Inertia\Response;
use App\Models\Target;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisterJobController extends Controller
{

    public function create(): Response
    {

        return Inertia::render('auth/NewJob', []);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
     
        $newjob = Jabatan::create(['name' => $request->jabatan]);
    
      
        function sidejob($job_id, $sidejob)
        {
            return Tugas::create([
                'name' => $sidejob,
                'jabatan_id' => $job_id
            ]);
        }
    
      
        function target($sidejob_id, $subjob, $slug)
        {
            return Target::create([
                'name' => $subjob,
                'tugas_id' => $sidejob_id,
                'slug' => $slug
            ]);
        }
    
   
        foreach ($request->jobs as $job) {
   
            $tugas = sidejob($newjob->id, $job['name']);
         
                foreach ($job['subJobs'] as $subjob) {
                    target($tugas->id, $subjob['name'], $request->slug);
                }
            
        }
       
    }
}    
