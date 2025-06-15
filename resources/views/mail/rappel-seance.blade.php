<style>
    .message {
        color: #111;
    }
    .app-name {
        font-style: italic;
    }
</style>

<x-mail::message>
# Rappel de cours

## Bonjour M., nous vous rappelons que vous avez cours aujourd'hui

<div class="message">

- Heure : {{ \Carbon\Carbon::parse($matiere->heure_deubt)->format('H:i') .' à '. \Carbon\Carbon::parse($matiere->heure_fin)->format('H:i') }}
- Matière : {{ $matiere->intitule }}
- Université : {{ $matiere->filiere->site->universite->nom }}
- Filière : {{ $matiere->filiere->libelle }}

</div>

<p class="app-name">
    {{ config('app.name') }}
</p>
</x-mail::message>
