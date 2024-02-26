<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        return Task::with(['user', 'category'])->paginate(30);
    }

    public function show($id)
    {
        $exist = Task::with(['user', 'category'])->find($id);
        return isset($exist) ?
            response()->json(['data' => $exist, 'message' =>'Task found']):
            response()->json(['error' => true, 'message' =>'Task not found']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'nullable|date',
            'status' => 'required|in:complete,processing,pending',
            'priority' => 'required|boolean',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $user = Auth::user();
        if ($request->filled('new_category_name')) {
            $newCategory = new Category([
                'name' => $request->new_category_name,
                'category_photo' => $request->new_category_photo,
            ]);
            $newCategory->user_id = $user->id;
            $newCategory->save();
            $request->merge(['category_id' => $newCategory->id]);
        }

        $task = Task::create($request->all());

        return response()->json(['data' => $task, 'message' => 'Task created']);
    }

    public function update(Request $request, $id)
    {
        $exist = Task::find($id);
        if (!$exist) {
            return response()->json(['error' => true, 'message' =>'Task not found']);
        }

        if ($request->filled('title')) $exist->title = $request->title;
        if ($request->filled('user_id')) $exist->user_id = $request->user_id;
        if ($request->filled('category_id')) $exist->category_id = $request->category_id;
        if ($request->filled('description')) $exist->description = $request->description;
        if ($request->filled('due_date')) $exist->due_date = $request->due_date;
        if ($request->filled('status')) $exist->status = $request->status;
        if ($request->filled('priority')) $exist->priority = $request->priority;

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
