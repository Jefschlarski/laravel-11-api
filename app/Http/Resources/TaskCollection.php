<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->collection->map(function ($task) {
            return [
                'id'             => $task->id,
                'title'          => $task->title,
                'description'    => $task->description,
                'created_by'     => $task->created_by,
                'task_status_id' => $task->task_status_id,
                'project_id'     => $task->project_id
            ];
        })->toArray();

        $count = count($data);

        return [
            'tasks' => $data,
            'count' => $count
        ];
    }
}
