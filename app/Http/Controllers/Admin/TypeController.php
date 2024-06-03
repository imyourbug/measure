<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Throwable;
use Toastr;

class TypeController extends Controller
{
    public function create()
    {
        return view('admin.type.add', [
            'title' => 'Thêm loại nhiệm vụ',
            'types' => Type::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'image' => 'nullable|string',
                'suggestion' => 'nullable|string',
                'note' => 'nullable|string',
                'parent_id' => 'required|numeric',
            ]);
            Type::create($data);
            Toastr::success('Tạo loại nhiệm vụ thành công', __('title.toastr.success'));
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), __('title.toastr.fail'));
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|int',
                'name' => 'required|string',
                'suggestion' => 'nullable|string',
                'note' => 'nullable|string',
                'image' => 'nullable|string',
                'parent_id' => 'required|numeric',
            ]);
            unset($data['id']);
            Type::where('id', $request->input('id'))->update($data);
            Toastr::success(__('message.success.update'), __('title.toastr.success'));
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), __('title.toastr.fail'));
        }

        return redirect()->back();
    }

    public function delete($id)
    {
        try {
            Type::firstWhere('id', $id)->delete();
            Toastr::success(__('message.success.delete'), __('title.toastr.success'));
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
                'types' => Type::with(['parent'])->get()
            ]);
        }

        return view('admin.type.list', [
            'title' => 'Danh sách loại nhiệm vụ',
            'types' => Type::all()
        ]);
    }

    public function show($id)
    {
        return view('admin.type.edit', [
            'title' => 'Chi tiết loại nhiệm vụ',
            'type' => Type::firstWhere('id', $id),
            'types' => Type::all()
        ]);
    }

    public function destroy($id)
    {
        try {
            Type::firstWhere('id', $id)->delete();

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

    public function getTypeByParentId(Request $request)
    {
        return response()->json([
            'status' => 0,
            'data' => Type::where('parent_id', $request->id)
                ->get()
        ]);
    }
}
