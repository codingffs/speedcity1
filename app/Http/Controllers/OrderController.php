<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookOrder;
use Validator;
use DB;
use Auth;
use DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bookOrder = BookOrder::latest()->get();
            return Datatables::of($bookOrder)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                            // $btn .= '<a href="'. route('localPackage.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                            // $btn .= '<a href="javascript:void(0)" data-url="'. route('localPackage.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            $btn .= '<a href="'. route('orders.show', $row->id) .'" class="edit btn btn-info btn-sm m-5" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
                        
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.order.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = BookOrder::find($id);
        return view('admin.order.show',compact('order'));
    }
}
