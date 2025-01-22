<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee_type' => [
                'id' => $this->employeeType->id,
                'name' => $this->employeeType->name
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name
            ],
            'created_by' => [
                'id' => $this->createdBy->id,
                'name' => $this->createdBy->name
            ],
        ];
    }
}
