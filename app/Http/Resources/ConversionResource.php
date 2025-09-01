<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'integer_value' => $this->integer_value,
            'roman' => $this->roman,
            'conversions_count' => $this->conversions_count,
            'last_converted_at' => $this->last_converted_at
        ];
    }
}
