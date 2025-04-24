<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function accueil()
    {
        $today = Carbon::createFromDate(now()->year, now()->month, now()->day);
        $dayWeek = $today->toArray()['dayOfWeek'];
        $dayWeek = ($dayWeek == 0) ? 7 : $dayWeek;

        $user = auth()->guard('web')->user();
        // $matieres = $user->enseignements()->get();
        // dd($matieres);
        
        return Inertia::render('Home');
    }

    public function calendrier()
    {}
}
