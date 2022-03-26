<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disease;
use DB;
use Auth;
use DataTables;
use File;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('disease-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $Disease = Disease::latest()->get();
            
            return Datatables::of($Disease)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->editcolumn('image', function($row){
                        $url = url("/images/disease"."/".$row->image);        
                        return '<img src="'. $url .'" height="80" weight="80"/>';
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('disease-edit')){
                            $btn .= '<a href="'. route('disease.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('disease-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('disease.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
        }
        
        return view('admin.disease.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('disease-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        return view('admin.disease.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('disease-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:diseases',
            'image' => 'required',
        ]);
        
        $imagename = rand(0000,9999).$request->image->getclientoriginalname();
        $request->image->move(public_path('images/disease'),$imagename);
        $Disease = array(
            "title" => $request->title,
            "image" => $imagename,
        );

        Disease::create($Disease);

        return redirect()->route("disease.index")->with("success", "Disease created successfully.");
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
        if(!Auth::user()->can('disease-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $Disease = Disease::find($id);

        return view('admin.disease.edit', compact('Disease'));
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
        $disease = Disease::find($id);
        if(!Auth::user()->can('disease-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:diseases,title,'.$id,
        ]);
        $Disease = array(
            "title" => $request->title,
        );
        if(isset($request->image) && !empty($request->image)){
            if(isset($disease->image) && $disease->image != ""){
            $image_path=public_path('images/disease').'/'.$disease->image;
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $imagename = rand(0000,9999).$request->image->getclientoriginalname();
            $request->image->move(public_path('images/disease'),$imagename);
            $Disease['image'] = $imagename;
           }

           Disease::whereId($id)->update($Disease);

        return redirect()->route("disease.index")->with("success", "Disease updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $disease = Disease::find($id);         
        File::delete(public_path('images/disease'. '/'.$disease->image));
        if(Disease::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
