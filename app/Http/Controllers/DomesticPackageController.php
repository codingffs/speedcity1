<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            $Domesticpackages = Domesticpackages::latest()->get();
            return Datatables::of($Domesticpackages)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                            $btn .= '<a href="'. route('domesticpackage.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('domesticpackage.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.domesticpackage.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.domesticpackage.create');
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
            'item_name' => 'required',
            'source_city' => 'required',
            'destination_city' => 'required',
            'price' => 'required',
            'notes' => 'required',
        ]);
        $Domesticpackages = array(
            "itemsID" => $request->item_name,
            "source_city" => $request->source_city,
            "destination_city" => $request->destination_city,
            "price" => $request->price,
            "notes" => $request->notes
        );
        Domesticpackages::create($Domesticpackages);

        return redirect()->route("domesticpackage.index")->with("success", "Domestic Package created successfully.");
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
        $Domesticpackages = Domesticpackages::find($id);

        return view('admin.domesticpackage.edit', compact('Domesticpackages'));
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
        $Domesticpackages = Domesticpackages::find($id);
        $request->validate([
            'item_name' => 'required',
            'source_city' => 'required',
            'destination_city' => 'required',
            'price' => 'required',
            'notes' => 'required',
        ]);
        $Domesticpackages = array(
            "itemsID" => $request->item_name,
            "source_city" => $request->source_city,
            "destination_city" => $request->destination_city,
            "price" => $request->price,
            "notes" => $request->notes
        );
        Domesticpackages::whereId($id)->update($Domesticpackages);

        return redirect()->route("domesticpackage.index")->with("success", "Domestic Package updated successfully.");
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
