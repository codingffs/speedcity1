<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\ProductAttribute;
use DB;
use Auth;
use DataTables;

class AttributeController extends Controller
{
    public function list(Request $request){

        if(!Auth::user()->can('attribute-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $Attribute = Attribute::latest()->get();
            
            return Datatables::of($Attribute)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->addColumn('action', function($row){
                        $btn = "";

                        if(Auth::user()->can('attribute-edit')){
                            $btn .= '<a href="'. route('attributes.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }

                        if(Auth::user()->can('attribute-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('attributes.delete', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }

                        if(Auth::user()->can('sub_attribute-list')){
                            $btn .= '<a href="'. route('sub_attributes', $row->id) .'" class="edit btn btn-primary btn-sm m-5" >Value Attributes</a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.attribute.list');
    }

    public function create(Request $request){
        if(!Auth::user()->can('attribute-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        return view('admin.attribute.create');
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

    public function get_dynamic_attribute(Request $request){
 
        $no = $request->attribute_no;
        $Attribute = Attribute::whereIn("id", $request->attribute_id)->get();

        if($request->product_id != ""){
            $ProductAttribute_data = ProductAttribute::whereProductId($request->product_id)->get();
            $viewRender = view('admin.attribute.get_dynamic_attribute_edit', compact('Attribute','no','ProductAttribute_data'))->render();
        } else {
            $viewRender = view('admin.attribute.get_dynamic_attribute', compact('Attribute','no'))->render();
        }
        
        return response()->json(array('success' => true, 'html' => $viewRender));
    }
}
