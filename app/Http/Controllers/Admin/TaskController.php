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
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Toastr;

class TaskController extends Controller
{
    public function create()
    {
        return view('admin.task.add', [
            'title' => 'Thêm nhiệm vụ',
            'staffs' => User::with('staff')->where('role', GlobalConstant::ROLE_STAFF)->get(),
            'contracts' => Contract::all(),
            'frequencies' => Frequency::all(),
            'items' => Item::all(),
            'maps' => Map::all(),
            'solutions' => Solution::all(),
            'chemistries' => Chemistry::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'type_id' => 'required|numeric',
            'chemistry_id' => 'required|numeric',
            'solution_id' => 'required|numeric',
            'item_id' => 'required|numeric',
            'frequency_id' => 'required|numeric',
            'contract_id' => 'required|numeric',
            'user_id' => 'nullable|numeric',
            'range' => 'nullable|string',
            'note' => 'nullable|string',
        ]);
        try {
            Task::create($data);
            Toastr::success('Tạo nhiệm vụ thành công', 'Thông báo');
        } catch (Throwable $e) {
            dd($e);
            Toastr::error('Tạo nhiệm vụ thất bại', 'Thông báo');
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|numeric',
            'name' => 'required|string',
            'type_id' => 'required|numeric',
            'chemistry_id' => 'required|numeric',
            'solution_id' => 'required|numeric',
            'item_id' => 'required|numeric',
            'frequency_id' => 'required|numeric',
            'contract_id' => 'required|numeric',
            'user_id' => 'nullable|numeric',
            'range' => 'nullable|string',
            'note' => 'nullable|string',
        ]);
        unset($data['id']);
        $update = Task::where('id', $request->input('id'))->update($data);
        if ($update) {
            Toastr::success(__('message.success.update'), 'Thông báo');
        } else Toastr::error(__('message.fail.update'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function index(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $tasks = Task::with([
            'user.staff', 'contract', 'type',
            'chemistry', 'solution', 'item', 'frequency'
        ])
            ->when($from, function ($q) use ($from) {
                return $q->where('created_at', '>=', $from . ' 00:00:00');
            })->when($to, function ($q) use ($to) {
                return $q->where('created_at', '<=', $to . ' 23:59:59');
            })->get();

        return view('admin.task.list', [
            'title' => 'Danh sách nhiệm vụ',
            'tasks' => $tasks
        ]);
    }

    public function show($id)
    {
        return view('admin.task.edit', [
            'title' => 'Chi tiết nhiệm vụ',
            'task' => Task::firstWhere('id', $id),
            'staffs' => User::with('staff')->where('role', GlobalConstant::ROLE_STAFF)->get(),
            'contracts' => Contract::all()
        ]);
    }

    public function destroy($id)
    {
        try {
            Task::firstWhere('id', $id)->delete();

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
