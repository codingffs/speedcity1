<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Offices;
use Validator;
use DB;
use Auth;
use DataTables;

class OfficesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $office = Offices::latest()->get();
            return Datatables::of($office)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                            $btn .= '<a href="'. route('offices.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('offices.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.office.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.office.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch_name' => 'required',
            'branch_code' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'contact' => 'required'
        ]);
        $office = array(
            "branch_name" => $request->branch_name,
            "branch_code" => $request->branch_code,
            "street" => $request->street,
            "city" => $request->city,
            "state" => $request->state,
            "zip_code" => $request->zip_code,
            "contact" => $request->contact
        );
        Offices::create($office);

        return redirect()->route("offices.index")->with("success", "Office created successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $office = Offices::find($id);

        return view('admin.office.edit', compact('office'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $office = Offices::find($id);
        $request->validate([
            'branch_name' => 'required',
            'branch_code' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'contact' => 'required'
        ]);
        $office = array(
            "branch_name" => $request->branch_name,
            "branch_code" => $request->branch_code,
            "street" => $request->street,
            "city" => $request->city,
            "state" => $request->state,
            "zip_code" => $request->zip_code,
            "contact" => $request->contact
        );
        Offices::whereId($id)->update($office);

        return redirect()->route("offices.index")->with("success", "Office updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Offices::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
