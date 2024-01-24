<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frequency;
use App\Models\Item;
use App\Models\Map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Toastr;

class FrequencyController extends Controller
{
    public function create()
    {
        return view('admin.frequency.add', [
            'title' => 'Thêm tần suất'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'day' => 'required|date',
            // 'week' => 'required|numeric',
            // 'month' => 'required|numeric',
            // 'year' => 'required|numeric',
            'time' => 'required|numeric',
            'active' => 'required|in:0,1',
        ]);
        // dd($data);
        try {
            Frequency::create($data);
            Toastr::success('Tạo tần suất thành công', 'Thông báo');
        } catch (Throwable $e) {
            dd($e);
            Toastr::error('Tạo tần suất thất bại', 'Thông báo');
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|numeric',
            'day' => 'required|date',
            // 'week' => 'required|numeric',
            // 'month' => 'required|numeric',
            // 'year' => 'required|numeric',
            'time' => 'required|numeric',
            'active' => 'required|in:0,1',
        ]);
        unset($data['id']);
        $update = Frequency::where('id', $request->input('id'))->update($data);
        if ($update) {
            Toastr::success(__('message.success.update'), 'Thông báo');
        } else Toastr::error(__('message.fail.update'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function index(Request $request)
    {
        return view('admin.frequency.list', [
            'title' => 'Danh sách tần suất',
            'frequencies' => Frequency::all()
        ]);
    }

    public function show($id)
    {
        return view('admin.frequency.edit', [
            'title' => 'Chi tiết tần suất',
            'frequency' => Frequency::firstWhere('id', $id)
        ]);
    }

    public function destroy($id)
    {
        try {
            Frequency::firstWhere('id', $id)->delete();

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
