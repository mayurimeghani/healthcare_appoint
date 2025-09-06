<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'status'     => $this->status,
            'start_time' => $this->appointment_start_time->toIso8601String(),
            'end_time'   => $this->appointment_end_time->toIso8601String(),
            'professional' => new HealthcareProfessionalResource($this->whenLoaded('professional'))
        ];
    }
}
