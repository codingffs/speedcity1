<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Localpackages;
use Validator;
use DB;
use Auth;
use DataTables;

class LocalPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $localPackage = Localpackages::latest()->get();
            return Datatables::of($localPackage)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                            $btn .= '<a href="'. route('localPackage.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('localPackage.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.localpackage.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.localpackage.create');
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
            'itemsID' => 'required',
            'source_address' => 'required',
            'destination_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'distance' => 'required',
            'price_per_km' => 'required',
            'notes' => 'required'
        ]);
        $localPackage = array(
            "itemsID" => $request->branch_name,
            "source_address" => $request->branch_code,
            "destination_address" => $request->street,
            "city" => $request->city,
            "state" => $request->state,
            "zip_code" => $request->zip_code,
            "distance" => $request->contact,
            "price_per_km" => $request->contact,
            "notes" => $request->contact
        );
        Localpackages::create($localPackage);

        return redirect()->route("localPackage.index")->with("success", "Local Package created successfully.");
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
        $localPackage = Localpackages::find($id);

        return view('admin.localpackage.edit', compact('localPackage'));
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
        $localPackage = Localpackages::find($id);
        $request->validate([
            'itemsID' => 'required',
            'source_address' => 'required',
            'destination_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'distance' => 'required',
            'price_per_km' => 'required',
            'notes' => 'required'
        ]);
        $localPackage = array(
            "itemsID" => $request->branch_name,
            "source_address" => $request->branch_code,
            "destination_address" => $request->street,
            "city" => $request->city,
            "state" => $request->state,
            "zip_code" => $request->zip_code,
            "distance" => $request->contact,
            "price_per_km" => $request->contact,
            "notes" => $request->contact
        );
        Localpackages::whereId($id)->update($localPackage);

        return redirect()->route("localPackage.index")->with("success", "Local Package updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Localpackages::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
