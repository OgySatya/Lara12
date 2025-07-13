<?php

namespace App\Http\Controllers\Absen;

use Carbon\Carbon;

use Inertia\Inertia;
use App\Models\Absen;
use Inertia\Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AbsenController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user([
            'id',
            'name',
            'awal',
            'ststus',
        ]);


        return Inertia::render('absen/Absen', [
            'user' => $user,
        ]);
    }
    public function update(Request $request)
    {
        $awalAbsen = User::find($request->Id);
        $awalAbsen->awal = $request->awal;
        $awalAbsen->save();
    }
    public function edit(Request $request)
    {

        $absen = User::find($request->absenId);
        $absen->status = $request->status;
        $absen->save();
    }
}
