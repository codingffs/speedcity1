<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consignment;
use App\Models\User;
use DB;
use Auth;
use DataTables;

class ConsignmentController extends Controller
{
    public function list(Request $request){

        if(!Auth::user()->can('consignment-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $Consignment = Consignment::latest()->get();
            
            return Datatables::of($Consignment)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->addColumn('action', function($row){
                        $btn = "";

                        if(Auth::user()->can('consignment-edit')){
                            $btn .= '<a href="'. route('consignment.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }

                        if(Auth::user()->can('consignment-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('consignment.delete', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.consignment.list');
    }

    public function create(Request $request){
        if(!Auth::user()->can('consignment-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $Supplier = User::where("type", "2")->get();

        return view('admin.consignment.create', compact('Supplier'));
    }

    public function store(Request $request){
        if(!Auth::user()->can('attribute-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'name' => 'required|unique:attributes',
        ]);

        $Attribute = array(
            "name" => $request->name,
        );

        Attribute::create($Attribute);

        return redirect()->route("attributes")->with("success", "Attribute created successfully.");
    }

    public function edit(Request $request, $id){
        if(!Auth::user()->can('attribute-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $Attribute = Attribute::find($id);

        return view('admin.attribute.edit', compact('Attribute'));
    }

    public function update(Request $request, $id){
        if(!Auth::user()->can('attribute-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'name' => 'required|unique:attributes,name,'.$id,
        ]);

        $Attribute = array(
            "name" => $request->name,
        );

        Attribute::whereId($id)->update($Attribute);

        return redirect()->route("attributes")->with("success", "Attribute updated successfully.");
    }

    public function delete($id){
        if(Attribute::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }

    public function get_product_detail_for_consignment(Request $request){
        echo "<pre>";
        print_r($request->all());
        exit;
    }
}
