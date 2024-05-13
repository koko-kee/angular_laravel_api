<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $tasks = Task::where('user_id',auth()->user()->id)->get();
        $tasks = auth()->user()->tasks;
        return response()->json([
            'statut' => 200,
            'data' => $tasks
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $task = auth()->user()->tasks()->create([
            'title' => $request->input('title'),
            'slug' =>  Str::slug($request->input('title')),
            'status' => $request->input('status'),
            'description' => $request->input('description'),
            'deadline' => $request->input('deadline')
        ]);

        if($task)
        {
            return response()->json([
                'statut' => 201,
                'data' => $task
            ]);
        }else{
            return response()->json([
                'statut' => 500,
                'data' => null
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = auth()->user()->tasks()->where('id',$id)->first();
        if($task)
        {
            return response()->json([
                'statut' => 200,
                'data' => $task
            ]);
        }else{
            return response()->json([
                'statut' => 404,
                'data' => null
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $task = auth()->user()->tasks()->where('id',$id)->first();
        if($task)
        {
            $task->title = $request->input('title');
            $task->slug = Str::slug($request->input('title'));
            $task->status = $request->input('status');
            $task->description = $request->input('description');
            $task->deadline = $request->input('deadline');
            $task->save();
            return response()->json([
                'statut' => 200,
                'data' => $task
            ]);
        }else{
            return response()->json([
                'statut' => 404,
                'data' => null
            ]);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = auth()->user()->tasks()->where('id',$id)->first();
        if($task)
        {
            $task->delete();
            return response()->json([
                'statut' => 204,
                'data' => null
            ]);
        }else{
            return response()->json([
                'statut' => 404,
                'data' => null
            ]);
        }
    }
}
