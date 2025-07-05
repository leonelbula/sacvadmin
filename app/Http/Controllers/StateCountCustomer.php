<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class StateCountCustomer extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index(){
        $title = "Cuentas por cobrar";

        $listCount = Customer::all();

        return view('statecountcustomer.index',compact('title'));
    }
}
