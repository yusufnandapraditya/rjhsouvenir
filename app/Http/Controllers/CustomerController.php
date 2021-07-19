<?php

namespace App\Http\Controllers;


use App\Customer;
use App\Exports\ExportCustomers;
use App\Imports\CustomersImport;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Excel;
use PDF;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,staff');
    }
    
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index');
    }

    
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama'      => 'required',
            'alamat'    => 'required',
            'email'     => 'required|unique:customers',
            'telepon'   => 'required',
        ]);

        Customer::create($request->all());

        return response()->json([
            'success'    => true,
            'message'    => 'Customer Created'
        ]);

    }

    public function destroy($id)
    {
        Customer::destroy($id);

        return response()->json([
            'success'    => true,
            'message'    => 'Customer Delete'
        ]);
    }




























    public function apiCustomers()
    {
        $customer = Customer::all();

        return Datatables::of($customer)
            ->addColumn('action', function($customer){
                return 
                    
                    '<a onclick="deleteData('. $customer->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['action'])->make(true);
    }

   
}
