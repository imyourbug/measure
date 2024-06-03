<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\TaskDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        return view('user.task.list', [
            'title' => 'Danh sách nhiệm vụ',
        ]);
    }

    public function show($task_id)
    {
        $tasks = TaskDetail::with([
            'task',
        ])->where('task_id', $task_id)
            ->get();

        return view('user.task.edit', [
            'title' => 'Danh sách chi tiết nhiệm vụ',
            'tasks' => $tasks,
            // 'contracts' => Contract::with(['branch'])->get(),
            // 'types' => Type::all(),
        ]);
    }

    public function taskToday()
    {
        $id = Auth::id();
        $today = now()->format('Y-m-d');

        return view('user.task.today', [
            'title' => 'Nhiệm vụ hôm nay: ' . now()->format('d-m-Y'),
        ]);
    }
}
