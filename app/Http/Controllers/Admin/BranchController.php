<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Customer;
use Illuminate\Http\Request;
use Throwable;
use Toastr;

class BranchController extends Controller
{
    public function getAll(Request $request)
    {
        $customer_id = $request->customer_id;
        $branches = Branch::with(['customer'])
            ->when($customer_id, function ($q) use ($customer_id) {
                return $q->whereHas('customer', function ($q) use ($customer_id) {
                    $q->where('id', $customer_id);
                });
            })
            ->get();

        return response()->json([
            'status' => 0,
            'branches' => $branches
        ]);
    }

    public function create()
    {
        return view('admin.branch.add', [
            'title' => 'Thêm chi nhánh',
            'customers' => Customer::all(),
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'address' => 'required|string',
                'tel' => 'required|string',
                'email' => 'required|regex:/^(.*?)@(.*?)$/',
                'manager' => 'required|string',
                'customer_id' => 'required|numeric',
            ]);
            Branch::create($data);
            Toastr::success('Tạo chi nhánh thành công', __('title.toastr.success'));
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
                'name' => 'required|string',
                'address' => 'required|string',
                'tel' => 'required|string',
                'email' => 'required|regex:/^(.*?)@(.*?)$/',
                'manager' => 'required|string',
                'customer_id' => 'required|numeric',
            ]);
            unset($data['id']);
            Branch::where('id', $request->input('id'))->update($data);
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
                'branches' => Branch::with(['customer'])->get(),
            ]);
        }

        return view('admin.branch.list', [
            'title' => 'Danh sách chi nhánh',
            'branches' => Branch::with(['customer'])->get(),
        ]);
    }

    public function show($id)
    {
        return view('admin.branch.edit', [
            'title' => 'Chi tiết chi nhánh',
            'branch' => Branch::with(['contracts.customer'])->firstWhere('id', $id),
            'customers' => Customer::all(),
        ]);
    }

    public function destroy($id)
    {
        try {
            Branch::firstWhere('id', $id)->delete();

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

    public function getBranchById(Request $request)
    {
        return response()->json([
            'status' => 0,
            'data' => Branch::where('customer_id', $request->id)->get()
        ]);
    }
}
