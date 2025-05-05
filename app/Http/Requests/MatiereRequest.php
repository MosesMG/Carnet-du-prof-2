<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatiereRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'intitule' => ['required', 'string', 'max:250'],
            'description' => ['nullable', 'string'],
            'jour' => ['required', 'integer', 'in:1,2,3,4,5,6,7'],
            'heure_debut' => ['required', 'string'],
            'heure_fin' => ['required', 'string'],
            'filiere_id' => ['required', 'integer', 'exists:filieres,id'],
        ];
    }
}
