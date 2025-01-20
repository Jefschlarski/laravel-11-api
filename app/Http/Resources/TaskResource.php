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
            'created_by' => [
                'id' => $this->user->id,
                'name' => $this->user->name
            ],
            'task_status' => [
                'id' => $this->task_status->id,
                'name' => $this->task_status->name],
            'project' => [
                'id' => $this->project->id,
                'name' => $this->project->name
            ]
        ];
    }
}
