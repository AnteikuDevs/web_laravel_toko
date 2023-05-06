<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['product'] = Product::count();
        $data['transaction'] = Transaction::sum('total');
        return view('admin.dashboard',$data);
    }
}
