<?php

use App\Models\Etudiant;
use App\Models\Seance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('matiere_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('etudiant_seance', function (Blueprint $table) {
            $table->foreignIdFor(Etudiant::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Seance::class)->constrained()->cascadeOnDelete();
            $table->primary(['etudiant_id', 'seance_id']);
            $table->boolean('presence')->default(false);
            $table->integer('plus')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seances');
        Schema::dropIfExists('etudiant_seance');
    }
};
