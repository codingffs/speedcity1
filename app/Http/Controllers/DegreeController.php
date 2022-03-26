<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Degree;
use DB;
use Auth;
use DataTables;
use File;
use URL;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('degree-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $Degree = Degree::latest()->get();
            
            return Datatables::of($Degree)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->editcolumn('image', function($row){
                        $url = url("/images/degree"."/".$row->image);  
                        $degreeimg = url("assets/images"."/".$row->image);  
                        if($row->image == 'degree.jpeg'){
                            return '<img src="'. $degreeimg .'" height="80" weight="80"/>';
                        }
                        else{
                            return '<img src="'. $url .'" height="80" weight="80"/>';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('degree-edit')){
                            $btn .= '<a href="'. route('degree.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('degree-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('degree.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
        }
        return view('admin.degree.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('degree-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        return view('admin.degree.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('degree-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:degrees',
        ]);
        
        if(isset($request->image)){
            $imagename = rand(0000,9999).$request->image->getclientoriginalname();
            $request->image->move(public_path('images/degree'),$imagename);
        }
        else{
            $imagename = 'degree.jpeg';
        }
        $Degree = array(
            "title" => $request->title,
            "image" => $imagename,
        );

        Degree::create($Degree);

        return redirect()->route("degree.index")->with("success", "Degree created successfully.");
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
        if(!Auth::user()->can('degree-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $Degree = Degree::find($id);

        return view('admin.degree.edit', compact('Degree'));
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
        $degree = Degree::find($id);
        if(!Auth::user()->can('degree-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:degrees,title,'.$id,
        ]);
        $Degree = array(
            "title" => $request->title,
        );
        if(isset($request->image) && !empty($request->image)){
            if(isset($degree->image) && $degree->image != ""){
            $image_path=public_path('images/degree').'/'.$degree->image;
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $imagename = rand(0000,9999).$request->image->getclientoriginalname();
            $request->image->move(public_path('images/degree'),$imagename);
            $Degree['image'] = $imagename;
           }

           Degree::whereId($id)->update($Degree);

        return redirect()->route("degree.index")->with("success", "Degree updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $degree = Degree::find($id);         
        File::delete(public_path('images/degree'. '/'.$degree->image));
        if(Degree::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
