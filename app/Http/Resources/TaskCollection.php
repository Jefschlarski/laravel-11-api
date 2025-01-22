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
            return TaskResource::make($task);
        })->toArray();

        $count = count($data);

        return [
            'tasks' => $data,
            'count' => $count
        ];
    }
}
