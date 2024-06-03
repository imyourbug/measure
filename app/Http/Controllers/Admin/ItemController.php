<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Throwable;
use Toastr;

class ItemController extends Controller
{
    public function create()
    {
        return view('admin.item.add', [
            'title' => 'Thêm vật tư'
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
                'supplier' => 'nullable|string',
                'active' => 'required|in:0,1',
            ]);
            Item::create($data);
            Toastr::success('Tạo vật tư thành công', __('title.toastr.success'));
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
                'supplier' => 'nullable|string',
                'active' => 'required|in:0,1',
            ]);
            unset($data['id']);
            Item::where('id', $request->input('id'))->update($data);
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
                'items' => Item::all()
            ]);
        }

        return view('admin.item.list', [
            'title' => 'Danh sách vật tư',
            'items' => Item::all()
        ]);
    }

    public function show($id)
    {
        return view('admin.item.edit', [
            'title' => 'Chi tiết vật tư',
            'item' => Item::firstWhere('id', $id)
        ]);
    }

    public function destroy($id)
    {
        try {
            Item::firstWhere('id', $id)->delete();

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
