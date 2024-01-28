<?php

namespace App\Http\Controllers\Admin;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\Chemistry;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Frequency;
use App\Models\InfoUser;
use App\Models\Item;
use App\Models\Map;
use App\Models\Solution;
use App\Models\Task;
use App\Models\TaskStaff;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Toastr;

class TaskStaffController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'task_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);
        try {
            TaskStaff::create($data);
            return response()->json([
                'status' => 0,
                'message' => 'Tạo nhiệm vụ thành công'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'id' => 'required|numeric',
            'task_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);
        unset($data['id']);
        try {
            TaskStaff::where('id', $request->input('id'))->update($data);
            return response()->json([
                'status' => 0,
                'message' => 'Cập nhật nhiệm vụ thành công'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function index(Request $request)
    {
        return response()->json([
            'status' => 0,
            'taskStaff' => TaskStaff::with(['task', 'user.staff'])
                ->where('task_id', $request->id)
                ->get(),
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'status' => 0,
            'taskStaff' => TaskStaff::with(['task', 'user'])->firstWhere('id', $id),
        ]);
    }

    public function destroy($id)
    {
        try {
            TaskStaff::firstWhere('id', $id)->delete();

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }
}
