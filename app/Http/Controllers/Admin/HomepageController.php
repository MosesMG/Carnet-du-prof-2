<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Universite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomepageController extends Controller
{
    public function accueil(): View
    {
        return view('accuiel', [
            'users' => User::count(),
            'universites' => Universite::count(),
        ]);
    }
}
