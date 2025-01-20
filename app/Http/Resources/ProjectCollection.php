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
            return [
                'id'          => $project->id,
                'name'        => $project->name,
                'description' => $project->description,
                'created_by'  => $project->created_by,
            ];
        })->toArray();

        $count = count($data);

        return [
            'projects' => $data,
            'count' => $count
        ];
    }
}
