<?php

namespace App\Extensions\Resources;
use Illuminate\Http\Request;

class ResourceCollection extends \Illuminate\Http\Resources\Json\ResourceCollection
{
    /**
     * Return the collection as an array.
     *
     * @return array
     */
    private function collectionToArray(): array
    {
        return $this->collection->toArray();
    }

    /**
     * Get pagination data for the collection.
     *
     * @return array<string, mixed> An array containing pagination details such as
     * 'per_page', 'total', and 'number_of_pages'.
     */

    private function getPaginationData(): array
    {
        $pages = ceil($this->total() / $this->perPage());
        return [
            'per_page' => $this->perPage(),
            'total' => $this->total(),
            'number_of_pages' => $pages
        ];
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collectionToArray(),
            'pagination' => $this->getPaginationData()
        ];
    }
}
