<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::with(['user', 'category', 'user_category'])->paginate(30);
    }

    public function show($id)
    {
        $exist = Task::with(['user', 'category', 'user_category'])->find($id);
        return isset($exist) ?
            response()->json(['data' => $exist, 'message' =>'Task found']):
            response()->json(['error' => true, 'message' =>'Task not found']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'user_category_id' => 'nullable|exists:user_categories,id',
            'description' => 'required',
            'due_date' => 'nullable|date',
            'status' => 'required|in:complete,processing,pending',
            'priority' => 'required|boolean',
        ]);

        $inputs = $request->input();
        $response = Task::create($inputs);
        return response()->json(['data' => $response, 'message' => 'Task created']);
    }

    public function update(Request $request, $id)
    {
        $exist = Task::find($id);
        if (!$exist) {
            return response()->json(['error' => true, 'message' =>'Task not found']);
        }

        if ($request->filled('title')) $exist->title = $request->title;
        if ($request->filled('user_id')) $exist->user_id = $request->user_id;
        if ($request->filled('description')) $exist->description = $request->description;
        if ($request->filled('due_date')) $exist->due_date = $request->due_date;
        if ($request->filled('status')) $exist->status = $request->status;
        if ($request->filled('priority')) $exist->priority = $request->priority;
        if ($request->filled('category_id')) {
            $exist->category_id = $request->category_id;
            $exist->user_category_id = null;
        } elseif ($request->filled('user_category_id')) {
            $exist->category_id = null;
            $exist->user_category_id = $request->user_category_id;
        }
        $exist->save();

        return response()->json(['data' => $exist, 'message' => 'Task updated']);
    }

    public function destroy($id)
    {
        $exist = Task::find($id);
        if (isset($exist)) {
            $delete = Task::destroy($id);
            return $delete ? response()->json(['data' => $exist,'message' =>'Task deleted']) : response()->json(['error' => true, 'message' => 'Failed to delete task']);
        }
        return response()->json(['error' => true, 'message' =>'Task not found']);
    }
}
