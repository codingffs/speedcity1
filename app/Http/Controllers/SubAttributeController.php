<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\SubAttribute;
use DB;
use Auth;
use DataTables;

class SubAttributeController extends Controller
{
    public function list(Request $request, $id){

        if(!Auth::user()->can('sub_attribute-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $SubAttribute = SubAttribute::where("attribute_id", $id)->latest()->get();
            
            return Datatables::of($SubAttribute)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('sub_attribute-edit')){
                            $btn .= '<a href="'. route('sub_attributes.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('sub_attribute-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('sub_attributes.delete', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.sub_attributes.list');
    }

    public function create(Request $request, $attribute_id){
        if(!Auth::user()->can('sub_attribute-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $Attribute = Attribute::whereId($attribute_id)->get();

        return view('admin.sub_attributes.create', compact('Attribute'));
    }

    public function store(Request $request, $id){
        if(!Auth::user()->can('sub_attribute-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $SubAttribute = SubAttribute::where("name", $request->name)->where("attribute_id", $id)->first();

        if(!empty($SubAttribute)){
            $request->validate([
                'name' => 'required|unique:sub_attributes',
            ]);
        }

        $SubAttribute = array(
            "attribute_id" => $id,
            "name" => $request->name,
        );

        SubAttribute::create($SubAttribute);

        return redirect()->route("sub_attributes", $id)->with("success", "Sub attribute created successfully.");
    }

    public function edit(Request $request, $id){
        if(!Auth::user()->can('sub_attribute-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $SubAttribute = SubAttribute::find($id);

        return view('admin.sub_attributes.edit', compact('SubAttribute'));
    }

    public function update(Request $request, $id){
        if(!Auth::user()->can('sub_attribute-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $SubAttribute = SubAttribute::where("name", $request->name)->where("attribute_id", $request->attribute_id)->where("id", "!=", $id)->first();

        if(!empty($SubAttribute)){
            $request->validate([
                'name' => 'required|unique:sub_attributes,name,'.$id,
            ]);
        }

        $SubAttribute = array(
            "name" => $request->name,
        );

        SubAttribute::whereId($id)->update($SubAttribute);

        return redirect()->route("sub_attributes",$request->attribute_id)->with("success", "Sub attribute updated successfully.");
    }

    public function delete($id){
        if(SubAttribute::where("id",$id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
