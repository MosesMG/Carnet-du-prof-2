<?php

namespace App\Http\Controllers;

use App\Mail\TestEnvoiMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Resend\Laravel\Facades\Resend;

class TestController extends Controller
{
    public function index() {
        return inertia('TestMail');
    }

    public function sendMail(Request $request) {
        $data = [
            'name' => $request->user()->name,
            'additionalInfo' => [
                'Heure' => Carbon::now()->format('d/m/Y H:i'),
                'Matière' => 'Anglais',
                'Université' => 'UCAO IUT',
                'Filière' => 'Génie Logiciel',
            ],
            'contact' => 'contact@newbrainfactory.com',
            'website' => 'https://newbrainfactory.com',
        ];

        try {
            Mail::to('moiseguenolekossou@gmail.com')->send(new TestEnvoiMail($data));

            return redirect(route('test.mail'))->with('success', 'Mail envoyé avec succès.');
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
