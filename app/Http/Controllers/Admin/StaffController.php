<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Toastr;

class StaffController extends Controller
{
    public function create()
    {
        return view('admin.staff.add', [
            'title' => 'Thêm nhân viên'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string',
                'avatar' => 'nullable|string',
                'position' => 'required|string',
                'identification' => 'required|string|regex:/\d{12}$/',
                'tel' => 'required|string|regex:/^0\d{9,10}$/',
                'active' => 'required|in:0,1',
            ];
            $data = $request->validate($rules);

            DB::beginTransaction();
            InfoUser::create([
                'name' => $data['name'],
                'avatar' => $data['avatar'],
                'position' => $data['position'],
                'identification' => $data['identification'],
                'tel' => $data['tel'],
                'active' => $data['active'],
            ]);
            Toastr::success('Tạo thành công', __('title.toastr.success'));
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            Toastr::error($e->getMessage(), __('title.toastr.fail'));
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|int',
                'avatar' => 'nullable|string',
                'name' => 'required|string',
                'position' => 'nullable|string',
                'identification' => 'required|string|regex:/\d{12}$/',
                'tel' => 'required|string|regex:/^0\d{9,10}$/',
                'active' => 'required|in:0,1',
            ]);
            unset($data['id']);
            $update = InfoUser::where('id', $request->input('id'))->update($data);
            Toastr::success(__('message.success.update'), __('title.toastr.success'));
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), __('title.toastr.fail'));
        }


        return redirect()->back();
    }

    public function show($id)
    {
        return view('admin.staff.edit', [
            'title' => 'Chi tiết nhân viên',
            'staff' => InfoUser::firstWhere('id', $id)
        ]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'status' => 0,
                'staff' => InfoUser::with(['user'])->get()
            ]);
        }

        return view('admin.staff.list', [
            'title' => 'Danh sách nhân viên',
        ]);
    }

    public function getAll(Request $request)
    {
        return response()->json([
            'status' => 0,
            'staff' => InfoUser::all()
        ]);
    }


    public function destroy($id)
    {
        try {
            InfoUser::firstWhere('id', $id)->delete();

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
