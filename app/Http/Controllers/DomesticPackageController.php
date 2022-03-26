<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domesticpackages;
use App\Models\CourierItems;
use Validator;
use DB;
use Auth;
use DataTables;

class DomesticPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $domesticpackages = Domesticpackages::latest()->get();
            return Datatables::of($domesticpackages)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                            $btn .= '<a href="'. route('domesticpackages.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('domesticpackages.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                            $btn .= '<a href="'. route('domesticpackages.show', $row->id) .'" class="edit btn btn-info btn-sm m-5" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
                        
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.domesticpackages.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $CourierItems = CourierItems::get();
        return view('admin.domesticpackages.create',compact('CourierItems'));
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
        $domesticpackages = array(
            "itemsID" => $request->itemsID,
            "source_address" => $request->source_address,
            "destination_address" => $request->destination_address,
            "city" => $request->city,
            "state" => $request->state,
            "zip_code" => $request->zip_code,
            "distance" => $request->distance,
            "price_per_km" => $request->price_per_km,
            "notes" => $request->notes
        );
        Domesticpackages::create($domesticpackages);

        return redirect()->route("domesticpackages.index")->with("success", "Local Package created successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $domesticpackages = Domesticpackages::find($id);
        return view('admin.domesticpackages.show',compact('domesticpackages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $domesticpackages = Domesticpackages::find($id);
        $CourierItems = CourierItems::get();

        return view('admin.domesticpackages.edit', compact('domesticpackages','CourierItems'));
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
        $domesticpackages = Domesticpackages::find($id);
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
        $domesticpackages = array(
            "itemsID" => $request->itemsID,
            "source_address" => $request->source_address,
            "destination_address" => $request->destination_address,
            "city" => $request->city,
            "state" => $request->state,
            "zip_code" => $request->zip_code,
            "distance" => $request->distance,
            "price_per_km" => $request->price_per_km,
            "notes" => $request->notes
        );
        Domesticpackages::whereId($id)->update($domesticpackages);

        return redirect()->route("domesticpackages.index")->with("success", "Local Package updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Domesticpackages::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
