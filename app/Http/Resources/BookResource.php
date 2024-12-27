<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nombre'=>$this->title,
            'autor'=>$this->author,
            'fecha de publicacion'=>$this->date_publication,
            'categoria'=>$this->category,
            'genero'=>$this->gender,
            'libreria'=>$this->id_library,
        ];
    }

    

    public function with($request)
    {
        return [
            'res'=>true,
        ];
    }
}
