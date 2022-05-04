<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'poster' => $this->poster_path,
            'pdf_url' => $this->pdf_url,
            'type' => $this->type,
            'release_date' => $this->release_date,
            'vote' => $this->vote,
            'vote_count' => $this->vote_count,
            'page_count' => $this->page_count,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
        ];

    }//end of to array

}//end of resource
