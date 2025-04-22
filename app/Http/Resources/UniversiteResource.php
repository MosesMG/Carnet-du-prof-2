<?php

namespace App\Http\Resources;

use App\Models\Universite;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UniversiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * @property Universite $resource
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'nom' => $this->resource->nom,
            'description' => $this->resource->description,
            'telephone' => $this->resource->telephone,
        ];
    }
}
