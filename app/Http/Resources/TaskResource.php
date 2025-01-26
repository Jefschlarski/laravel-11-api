<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'closed_at' => $this->closed_at,
            'created_by' => [
                'id' => $this->createdBy->id,
                'name' => $this->createdBy->name
            ],
            'task_status' => [
                'id' => $this->taskStatus->id,
                'name' => $this->taskStatus->name],
            'project' => [
                'id' => $this->project->id,
                'name' => $this->project->name
            ],
        ];
    }
}
