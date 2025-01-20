<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskStatusCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->collection->map(function ($task_status) {
            return [
                'id'          => $task_status->id,
                'name'        => $task_status->name,
                'description' => $task_status->description,
                'created_by'  => $task_status->created_by,
            ];
        })->toArray();

        $count = count($data);

        return [
            'task_statuses' => $data,
            'count' => $count
        ];
    }
}
