<?php

namespace App\Http\Resources;

use App\Http\Controllers\CategoryController;
use App\Http\Resources\SceneResource as SceneResource;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\User as UserResource;
use App\Models\Card;
use App\Models\User;
use App\Models\Category;
use App\Models\scene;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $scene = scene::all()->where('id', '=', $this->scene_id);
        $user = User::all()->where('id', '=', $this->user_id);
        $card = Card::all()->where('url', '=', $request);
        return [
            'id' => $this->id,

            'title' => $this->title,
            'name' => $this->name,
            'content' => $this->text,
            //'user_id' =>$this->user_id,
            'user' => User::all('id','name')->where('id', '=', $this->user_id),
            'url' => $this->url,

            'category' => Category::all('id','title')->where('id', '=', $this->category_id)->first(),

            'scene' => SceneResource::collection($scene),
            'image' => $this->image,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),

        ];
    }
}
//$card = Card::all()->where('id', '=', Auth::user()->id);
//return [
//    'id' => $this->id,
//    'name' => $this->name,
//    'email' => $this->email,
//    'tasks' => CardResource::collection($card)
