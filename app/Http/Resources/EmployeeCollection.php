<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->collection->map(function ($employee) {
            return EmployeeResource::make($employee);
        })->toArray();

        $count = count($data);

        return [
            'employees' => $data,
            'count' => $count
        ];
    }
}
