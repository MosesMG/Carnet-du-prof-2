<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DataNotifController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\MatiereController;
use App\Http\Controllers\User\SeanceController;
use App\Http\Controllers\User\UniversiteController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/accueil', [HomeController::class, 'accueil'])->name('dashboard');

    Route::get('/calendrier', [HomeController::class, 'calendrier'])->name('calendrier');

    Route::controller(UniversiteController::class)->group(function () {

        Route::get('/universites', 'index')->name('universites');

        Route::get('/universites/{site}', 'choixFiliere')->name('sites.choix');
        
        Route::get('universite/{site}/filieres', 'mesFilieres')->name('mes.filieres');
    });

    Route::controller(MatiereController::class)->group(function () {

        Route::get('/filiere/{filiere}/matieres', 'mesMatieres')->name('mes.matieres');

        Route::post('/filiere/{filiere}/matieres/add', 'storeMatiere')->name('matieres.store');

        Route::patch('/filiere/{filiere}/matieres/{matiere}/edit', 'updateMatiere')
                ->name('matieres.update');

        Route::delete('/filiere/{filiere}/matieres/{matiere}/delete', 'deleteMatiere')
                ->name('matieres.delete');

        Route::post('/filiere/{filiere}/matieres', 'importEtudiants')->name('import.etudiants');

        Route::put('/filiere/{filiere}/tauxhr', 'tauxHoraire')->name('filiere.tauxhr');
    });

    Route::controller(SeanceController::class)->group(function () {

        Route::get('/matiere/{matiere}/seances', 'lesSeances')->name('matiere.seance');

        Route::post('/matiere/{matiere}/seances', 'startSeance')->name('seance.start');
    
        Route::get('/matiere/{matiere}/seance/{seance}', 'showSeance')->name('seance.show');
        
        Route::patch('/matiere/{matiere}/seance/{seance}', 'stopSeance')->name('seance.stop');

        Route::put('/matiere/{matiere}/seance/{seance}', 'infoSaveSeance')->name('seance.infos');
    
        Route::put('/matiere/{matiere}/notes', 'notEtudiants')->name('etudiant.notes');
    });

    Route::controller(DataNotifController::class)->group(function () {

        Route::get('/rappels', 'lesRappels')->name('les.rappels');

        Route::delete('/rappel/{rappel}', 'deleteRappel')->name('rappel.delete');

        Route::delete('/rappels/delete', 'deleteAllRappels')->name('all.rappel.delete');

        Route::get('/donnees', 'index')->name('les.donnees');
    });
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
