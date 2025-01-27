<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'created_by' => [
                'id' => $this->createdBy->id,
                'name' => $this->createdBy->name
            ],
        ];
    }
}
