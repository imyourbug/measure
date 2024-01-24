<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Controller;
use App\Models\InfoUser;
use App\Models\User;
use Illuminate\Http\Request;
use Toastr;

class InfoUserController extends Controller
{

    public function __construct(private AccountController $controller)
    {
    }

    public function create()
    {
        return view('admin.staff.add', [
            'title' => 'Thêm nhân viên'
        ]);
    }

    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'name' => 'required|string',
    //         'address' => 'required|string',
    //         'tel' => 'required|string|regex:/^0\d{9,10}$/',
    //         'fax' => 'required|string',
    //     ]);
    //     try {
    //         InfoUser::create($data);
    //         Toastr::success('Tạo nhân viên thành công', 'Thông báo');
    //     } catch (Throwable $e) {
    //         dd($e);
    //         Toastr::error('Tạo nhân viên thất bại', 'Thông báo');
    //     }

    //     return redirect()->back();
    // }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|int',
            'avatar' => 'required|string',
            'name' => 'required|string',
            'position' => 'required|string',
            'identification' => 'required|string|regex:/\d{12}$/',
            'tel' => 'required|string|regex:/^0\d{9,10}$/',
            'active' => 'required|in:0,1',
        ]);
        unset($data['id']);
        $update = InfoUser::where('id', $request->input('id'))->update($data);
        if ($update) {
            Toastr::success(__('message.success.update'), 'Thông báo');
        } else Toastr::error(__('message.fail.update'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function index(Request $request)
    {
        return view('admin.staff.list', [
            'title' => 'Danh sách nhân viên',
            'staffs' => InfoUser::all()
        ]);
    }

    public function show($id)
    {
        return view('admin.staff.edit', [
            'title' => 'Chi tiết nhân viên',
            'staff' => InfoUser::firstWhere('id', $id)
        ]);
    }

    public function destroy($user_id)
    {
        return $this->controller->destroy($user_id);
    }
}
