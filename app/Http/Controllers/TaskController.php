<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['user', 'category'])->paginate(5);
        return response()->json(['tasks' => $tasks]);
    }

    public function show(Task $task)
    {
        return response()->json(['task' => $task]);
    }

    public function store(Request $request)
    {
        $task = Task::create($request->all());
        return response()->json(['task' => $task], 201);
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return response()->json(['task' => $task]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}
