<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Task as TaskResource;
use App\Models\Task;
use Validator;


class TaskController extends BaseController
{

//    public function __construct($balance)
//    {
//        $this->balance = $balance;
//    }
////
//    public function __construct(Builder $query, Model $parent, $foreignKeys, $localKey)
//    {
//        $this->foreignKeys = $foreignKeys;
//
//        parent::__construct($query, $parent, $foreignKeys[0], $localKey);
//    }

    public function index()
    {
        $tasks = Task::all()->where('user_id', '=', Auth::user()->id);

        return $this->handleResponse(TaskResource::collection($tasks), 'Tasks have been retrieved!');
    }


    public function store(Request $request)
    {
        $input = $request->all();

        $user = Auth::user();

        $validator = Validator::make($input, [
            'name' => 'required',
            'details' => 'required'
        ]);

        if($validator->fails()){
            return $this->handleError($validator->errors());
        }

        $task = Task::create([
            "user_id" => $user->id,
            "name" => $request->name,
            "details" => $request->details,

        ]);
        return $this->handleResponse($task, 'Task created!');
    }


    public function show($id)
    {
        $task = Task::find($id);
        if (is_null($task)) {
            return $this->handleError('Task not found!');
        }
        return $this->handleResponse(new TaskResource($task), 'Task retrieved.');
    }


    public function update(Request $request, Task $task)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'details' => 'required'
        ]);

        if($validator->fails()){
            return $this->handleError($validator->errors());
        }

        $task->name = $input['name'];
        $task->details = $input['details'];
        $task->save();

        return $this->handleResponse(new TaskResource($task), 'Task successfully updated!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return $this->handleResponse([], 'Task deleted!');
    }
}
