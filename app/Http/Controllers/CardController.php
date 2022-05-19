<?php

namespace App\Http\Controllers;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\CardResource;
use App\Http\Resources\SceneResource;
use App\Http\Resources\Task as TaskResource;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
class CardController extends BaseController
{
    public function url($url) {
        $card = Card::all()->where('url', '=',$url);

        return $this->handleResponse(CardResource::collection($card), 'Card info');
    }

    public function index() {

        $card = Card::all()->where('id', '=', Auth::user()->id);
        return $this->handleResponse(CardResource::collection($card), 'Cards have been retrieved!');
    }

    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
    public function cards(Request $request) {
        $card = Card::all();
        return $this->handleResponse(CardResource::collection($card), 'Cards have been retrieved!');
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'title' => 'required',
            'text' => 'required',
            'scene_id' => 'required',
            'category_id' => 'required'
        ]);
        if($validator->fails()){
            return $this->handleError($validator->errors());
        }

        if($request->image) {
            $data['image'] = $request->image->store('/', 'public');

            $card = Card::create([
                "name" => $request->name,
                "title" => $request->title,
                "text" => $request->text,
                "url" => $this->quickRandom(5),
                "scene_id" => $request->scene_id,
                "category_id" => $request->category_id,
                "user_id" => Auth::user()->id,
                "image" => $data['image'],
            ]);
        } else {
            $card = Card::create([
                "name" => $request->name,
                "title" => $request->title,
                "text" => $request->text,
                "url" => $this->quickRandom(5),
                "scene_id" => $request->scene_id,
                "category_id" => $request->category_id,
                "user_id" => Auth::user()->id
            ]);
        }


        return $this->handleResponse(new CardResource($card), 'Card created!');
    }
}
