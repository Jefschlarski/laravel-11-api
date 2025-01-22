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
            return TaskStatusResource::make($task_status);
        })->toArray();

        $count = count($data);

        return [
            'task_statuses' => $data,
            'count' => $count
        ];
    }
}
