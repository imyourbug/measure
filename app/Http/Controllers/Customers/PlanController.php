<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        return view('customer.plan.list', [
            'title' => 'Danh sách kế hoạch',
            'customer' => Customer::firstWhere('email', $user->email),
            'contracts' => Contract::with('customer')->get(),
        ]);
    }
}
