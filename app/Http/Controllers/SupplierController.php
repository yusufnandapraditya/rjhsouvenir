<?php

namespace App\Http\Controllers;


use App\Exports\ExportSuppliers;
use App\Imports\SuppliersImport;
use App\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Excel;
use PDF;


class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,staff');
    }
   
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index');
    }

    
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama'      => 'required',
            'alamat'    => 'required',
            'email'     => 'required|unique:suppliers',
            'telepon'   => 'required',
        ]);

        Supplier::create($request->all());

        return response()->json([
            'success'    => true,
            'message'    => 'Suppliers Created'
        ]);

    }

    
    public function destroy($id)
    {
        Supplier::destroy($id);

        return response()->json([
            'success'    => true,
            'message'    => 'Supplier Delete'
        ]);
    }






























    public function apiSuppliers()
    {
        $suppliers = Supplier::all();

        return Datatables::of($suppliers)
            ->addColumn('action', function($suppliers){
                return 
                   
                    '<a onclick="deleteData('. $suppliers->id .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            })
            ->rawColumns(['action'])->make(true);
    }

   
}
