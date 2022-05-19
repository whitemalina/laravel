<?php

namespace App\Http\Resources;

use App\Http\Resources\CardResource as CardResource;
use App\Models\Card;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $card = Card::all()->where('id', '=', Auth::user()->id);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'tasks' => CardResource::collection($card),
            'image' => $this->image,
            'banner' => $this->banner,
        ];
    }
}
