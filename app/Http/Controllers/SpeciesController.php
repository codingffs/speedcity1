<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Species;
use DB;
use Auth;
use DataTables;
use File;

class SpeciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   $Species = Species::get();
        if ($request->ajax()) {
            $Species = Species::get();
            
            return Datatables::of($Species)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->editcolumn('image', function($row){
                        $url = url("/species"."/".$row->image);        
                        return '<img src="'. $url .'" height="80" weight="80"/>';
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                            $btn .= '<a href="'. route('species.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('species.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
        }
        
        return view('admin.Species.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Species.create');
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
            'species_name' => 'required',
            'scientific_name' => 'required',
            'family' => 'required',
            'silvicultural_requirements' => 'required',
            'species_description' => 'required',
            'utility' => 'required',
            'image' => 'required',
        ]);
        
        $imagename = rand(0000,9999).$request->image->getclientoriginalname();
        $request->image->move(public_path('/species'),$imagename);
        $Species = array(
            "species_name" => $request->species_name,
            "scientific_name" => $request->scientific_name,
            "family" => $request->family,
            "silvicultural_requirements" => $request->silvicultural_requirements,
            "species_description" => $request->species_description,
            "utility" => $request->utility,
            "image" => $imagename,
        );

        Species::create($Species);

        return redirect()->route("species.index")->with("success", "Species created successfully.");
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
             $Species = Species::find($id);
             return view('admin.Species.edit', compact('Species'));
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
        $Species = Species::find($id);
        $request->validate([
            'species_name' => 'required',
            'scientific_name' => 'required',
            'family' => 'required',
            'silvicultural_requirements' => 'required',
            'species_description' => 'required',
            'utility' => 'required',
        ]);
        $imagename = $Species->image;
        if(isset($request->image) && !empty($request->image)){
            if(isset($Species->image) && $Species->image != ""){
            $image_path=public_path('/species').'/'.$Species->image;
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $imagename = rand(0000,9999).$request->image->getclientoriginalname();
            $request->image->move(public_path('/species'),$imagename);
            $Species['image'] = $imagename;
           }
        $Species = array(
            "species_name" => $request->species_name,
            "scientific_name" => $request->scientific_name,
            "family" => $request->family,
            "silvicultural_requirements" => $request->silvicultural_requirements,
            "species_description" => $request->species_description,
            "utility" => $request->utility,
            "image" => $imagename,
        );
       

        Species::whereId($id)->update($Species);

        return redirect()->route("species.index")->with("success", "Species updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Species = Species::find($id);  
        // $medicalappliance = MedicalAppliance::where('cat_id',$id)->delete();       
        File::delete(public_path('/species'. '/'.$Species->image));
        if(Species::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
    public function check_title_exists(Request $request)
    {
        $rules = [
            'title'=> 'required|unique:categories,title',
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
    public function check_title_exists_update(Request $request)
    {
        $rules = [
            'title'=> 'required|unique:categories,title,'.$request->id,
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
