<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Solution;
use Illuminate\Http\Request;
use Throwable;
use Toastr;

class SolutionController extends Controller
{
    public function create()
    {
        return view('admin.solution.add', [
            'title' => 'Thêm phương pháp'
        ]);
    }

    public function store(Request $request)
    {

        try {
            $data = $request->validate([
                // 'code' => 'required|string',
                'name' => 'required|string',
                'target' => 'nullable|string',
                'image' => 'nullable|string',
                'description' => 'nullable|string',
                'active' => 'required|in:0,1',
            ]);
            Solution::create($data);
            Toastr::success('Tạo phương pháp thành công', __('title.toastr.success'));
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), __('title.toastr.fail'));
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|numeric',
                // 'code' => 'required|string',
                'name' => 'required|string',
                'target' => 'nullable|string',
                'image' => 'nullable|string',
                'description' => 'nullable|string',
                'active' => 'required|in:0,1',
            ]);
            unset($data['id']);
            Solution::where('id', $request->input('id'))->update($data);
            Toastr::success(__('message.success.update'), __('title.toastr.success'));
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), __('title.toastr.fail'));
        }

        return redirect()->back();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'status' => 0,
                'solutions' => Solution::all()
            ]);
        }

        return view('admin.solution.list', [
            'title' => 'Danh sách phương pháp',
            'solutions' => Solution::all()
        ]);
    }

    public function show($id)
    {
        return view('admin.solution.edit', [
            'title' => 'Chi tiết phương pháp',
            'solution' => Solution::firstWhere('id', $id)
        ]);
    }

    public function destroy($id)
    {
        try {
            Solution::firstWhere('id', $id)->delete();

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
