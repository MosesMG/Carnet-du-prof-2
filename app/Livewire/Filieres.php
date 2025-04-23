<?php

namespace App\Livewire;

use App\Models\Site;
use App\Models\Filiere;
use Livewire\Component;

class Filieres extends Component
{
    public $niveau = '';

    public string $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $site = Site::find($this->id);

        if ($this->niveau == '') {
            $filieres = Filiere::with('niveau')->where('site_id', '=', $this->id)->get();
        }

        $filieres = Filiere::with('niveau')
                        ->where('site_id', '=', $this->id)
                        ->whereHas('niveau', function ($query) {
                            $query->where('libelle', 'LIKE', $this->niveau . '%');
                        })->get();
        
        return view('livewire.filieres', [
            'site' => $site,
            'filieres' => $filieres
        ]);
    }
}
