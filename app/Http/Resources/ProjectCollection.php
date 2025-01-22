<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->collection->map(function ($project) {
            return ProjectResource::make($project);
        })->toArray();

        $count = count($data);

        return [
            'projects' => $data,
            'count' => $count
        ];
    }
}
