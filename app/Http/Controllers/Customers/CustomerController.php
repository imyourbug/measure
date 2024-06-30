<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        return view('customer.home', [
            'title' => 'Khách hàng - ' . $user->email ??  $user->name,
            'customer' => Customer::firstWhere('email', $user->email),
        ]);
    }
}
