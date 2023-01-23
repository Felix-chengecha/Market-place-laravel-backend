<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class allproductsResource extends JsonResource
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

            'id'=>$this->id,
            'title' => $this->title,
            'cost' => $this->price,
            'image' => $this->image,
            // $response['MSG'] =>  "product result"



        ];
    }
}
