<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\MatiereController;
use App\Http\Controllers\User\UniversiteController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/accueil', [HomeController::class, 'accueil'])->name('dashboard');

    Route::get('/calendrier', [HomeController::class, 'calendrier'])->name('calendrier');

    Route::controller(UniversiteController::class)->group(function () {

        Route::get('/universites', 'index')->name('universites');

        Route::get('/universites/{site}', 'choixFiliere')->name('sites.choix');
        
        Route::get('/{site}/filieres', 'mesFilieres')->name('mes.filieres');
    });

    Route::controller(MatiereController::class)->group(function () {

        Route::get('/filiere/{filiere}/matieres', 'mesMatieres')->name('mes.matieres');

        // Route::get('/filiere/{filiere}/matieres/ajouter', 'ajoutMatiere')->name('matieres.ajout');
        Route::post('/filiere/{filiere}/matieres/add', 'storeMatiere')->name('matieres.store');

        // Route::get('/filiere/{filiere}/matieres/{matiere}/editer', 'editMatiere')->name('matieres.edit');
        Route::patch('/filiere/{filiere}/matieres/{matiere}/edit', 'updateMatiere')->name('matieres.update');

        Route::delete('/filiere/{filiere}/matieres/{matiere}/delete', 'deleteMatiere')->name('matieres.delete');

        Route::post('/filiere/{filiere}/matieres', 'importEtudiants')->name('import.etudiants');

        Route::put('/filiere/{filiere}/tauxhr', 'tauxHoraire')->name('filiere.tauxhr');
        // Route::patch('/filiere/{filiere}/tauxhr', 'modifTauxHoraire')->name('filiere.modiftauxhr');

        Route::get('/matiere/{matiere}/seances', 'lesSeances')->name('matiere.seance');
        Route::post('/matiere/{matiere}/seances', 'startSeance')->name('seance.start');

        Route::get('/matiere/{matiere}/seance/{seance}', 'showSeance')->name('seance.show');
        Route::put('/matiere/{matiere}/seance/{seance}', 'stopSeance')->name('seance.stop');

        Route::post('/matiere/{matiere}/notes', 'notEtudiants')->name('etudiant.notes');
    });
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
