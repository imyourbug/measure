<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Toastr;

class CustomerController extends Controller
{
    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|int',
                'name' => 'required|string',
                'address' => 'required|string',
                'tel' => 'required|string|regex:/^0\d{9,10}$/',
                'email' => 'required|regex:/^(.*?)@(.*?)$/',
            ]);
            unset($data['id']);
            Customer::where('id', $request->input('id'))->update($data);
            Toastr::success(__('message.success.update'), __('title.toastr.success'));
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), __('title.toastr.fail'));
        }

        return redirect()->back();
    }

    public function me(Request $request)
    {
        return view('customer.me', [
            'title' => 'Thông tin cá nhân',
            'customer' => User::with(['customer'])
                ->firstWhere('id', Auth::id())
                ->customer
        ]);
    }
}
