<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\InfoUser;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $customer_id = Customer::firstWhere('email', Auth::user()->email)->id ?? '';

        return view('customer.report.list', [
            'title' => 'Báo cáo nhiệm vụ',
            'contracts' => Contract::with(['customer', 'branch'])
                ->whereHas('customer', function ($q) use ($customer_id) {
                    $q->where('id', $customer_id);
                })
                ->get(),
            'types' => Type::all(),
            'staff' => InfoUser::all(),
        ]);
    }
}
