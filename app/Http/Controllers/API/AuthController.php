<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;

use App\Http\Resources\Task as TaskResource;

use App\Models\User;
use Validator;

use App\Http\Resources\User as UserResource;


class AuthController extends BaseController
{
//    public function __construct()
//    {
//        $this->middleware('auth:api')->only(['posts', 'store', 'update', 'destroy', 'index']);
//    }



    public function index()
    {
        $user = Auth::user();
        return $this->handleResponse(new UserResource($user), 'User logged-in!');

//        return PostResource::collection(Auth::user()->posts);
//        return $this->handleResponse($user, 'User logged-in!');

    }
    public function update(Request $request)
    {
        $user = Auth::user();
        if($request->image) {
            $data['image'] = $request->image->store('/', 'public');
            $input = $request->all();
            $input['image'] = $data['image'];
        } else {
            $input = $request->all();
        }

        $user->fill($input)->save();
        return $this->handleResponse(new UserResource($user), 'User updated');
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $auth = Auth::user();
            $success['token'] =  $auth->createToken('LaravelSanctumAuth')->plainTextToken;
            $success['name'] =  $auth->name;

            return $this->handleResponse($success, 'User logged-in!');
        }
        else{
            return $this->handleError('Unauthorized', ['error'=>'Unauthorized']);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->handleError($validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('LaravelSanctumAuth')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->handleResponse($success, 'User successfully registered!');
    }

}
