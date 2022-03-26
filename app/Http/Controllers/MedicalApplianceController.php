<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalAppliance;
use App\Models\Category;
use DB;
use Auth;
use DataTables;
use File;

class MedicalApplianceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('medicalappliance-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        if ($request->ajax()) {
            $medicalappliance = MedicalAppliance::latest()->get();
            return Datatables::of($medicalappliance)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->editcolumn('description', function($row){
                        $des = $row->description;
                        return $des;
                    })
                    ->editcolumn('image', function($row){
                        $url = url("/images/medicalappliance"."/".$row->image);        
                        return '<img src="'. $url .'" height="80" weight="80"/>';
                    })
                    ->editColumn('cat_id', function($row){
                        return getcatgoryname($row->cat_id); ;
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('medicalappliance-edit')){
                            $btn .= '<a href="'. route('medicalappliance.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('medicalappliance-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('medicalappliance.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action','image','description'])
                    ->make(true);
        }
        
        return view('admin.medicalappliance.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('medicalappliance-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $medicalcategory = Category::get();
        return view('admin.medicalappliance.create',compact('medicalcategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('medicalappliance-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|max:100|unique:medicalappliances,title',
            'price' => 'required',
            'description' => 'required',
            'image' => 'required',
            
        ]);
        $imagename = rand(0000,9999).$request->image->getclientoriginalname();
        $request->image->move(public_path('images/medicalappliance'),$imagename);
        $medicalappliance = array(
            "title" => $request->title,
            "price" => $request->price,
            "description" => $request->description,
            "cat_id" => $request->medicalcategory,
            "image" => $imagename,
        );

        MedicalAppliance::create($medicalappliance);

        return redirect()->route("medicalappliance.index")->with("success", "Medical Appliance created successfully.");
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
        if(!Auth::user()->can('medicalappliance-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $Category = MedicalAppliance::find($id);
        $medicalcategory = Category::get();

        return view('admin.medicalappliance.edit', compact('Category','medicalcategory'));
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
        $medicalappliance1 = MedicalAppliance::find($id);
        if(!Auth::user()->can('medicalappliance-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|max:100|unique:medicalappliances,title,'.$id,
            'price' => 'required',
            'description' => 'required',
            
        ]);
        $medicalappliance = array(
            "title" => $request->title,
            "description" => $request->description,
            "price" => $request->price,
            "cat_id" => $request->medicalcategory,
        );
        if(isset($request->image) && !empty($request->image)){
            if(isset($medicalappliance1->image) && $medicalappliance1->image != ""){
                $image_path=public_path('images/medicalappliance').'/'.$medicalappliance1->image;
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $imagename = rand(0000,9999).$request->image->getclientoriginalname();
            $request->image->move(public_path('images/medicalappliance'),$imagename);
            $medicalappliance['image'] = $imagename;
        }

           MedicalAppliance::whereId($id)->update($medicalappliance);

        return redirect()->route("medicalappliance.index")->with("success", "Medical Appliance updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medicalappliance = MedicalAppliance::find($id);         
        File::delete(public_path('images/medicalappliance'. '/'.$medicalappliance->image));
        if(MedicalAppliance::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }

    public function check_medical_title_exists(Request $request)
    {
        $rules = [
            'title'=> 'required|unique:medicalappliances,title',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            $res = [
                'message' => "Title Already Exists!",
                'status' => 0,
            ];
        
            return $res; 
        }
        $res = [
            'message' => 'success',
            'status' => 1,
        ];
        return $res;
    }
   
    public function check_medical_title_exists_update(Request $request)
    {
        $rules = [
            'title'=> 'required|unique:medicalappliances,title,'.$request->id,
        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            $res = [
                'message' => "Title Already Exists!",
                'status' => 0,
            ];
        
            return $res; 
        }
        $res = [
            'message' => 'success',
            'status' => 1,
        ];
        return $res;
    }
   
}
