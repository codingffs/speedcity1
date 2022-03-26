<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services;
use DB;
use Auth;
use DataTables;
use File;


class ServicesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('services-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $Services = Services::latest()->get();
            
            return Datatables::of($Services)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->editcolumn('description', function($row){
                        $des = $row->description;
                        return $des;
                    })
                    ->editcolumn('image', function($row){
                        $url = url("/images/services"."/".$row->image);        
                        return '<img src="'. $url .'" height="80" weight="80"/>';
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('services-edit')){
                            $btn .= '<a href="'. route('services.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('services-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('services.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action','image','description'])
                    ->make(true);
        }
        
        return view('admin.services.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('services-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('services-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:services',
            'description' => 'required',
            'image' => 'required',
        ]);
        
        $imagename = rand(0000,9999).$request->image->getclientoriginalname();
        $request->image->move(public_path('images/services'),$imagename);
        $Services = array(
            "title" => $request->title,
            "description" => $request->description,
            "image" => $imagename,
        );

        Services::create($Services);

        return redirect()->route("services.index")->with("success", "Services created successfully.");
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
        if(!Auth::user()->can('services-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $Services = Services::find($id);

        return view('admin.services.edit', compact('Services'));
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
        $services = Services::find($id);
        if(!Auth::user()->can('services-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:services,title,'.$id,
            'description' => 'required',
        ]);
        $Services = array(
            "title" => $request->title,
            "description" => $request->description,
        );
        if(isset($request->image) && !empty($request->image)){
            if(isset($services->image) && $services->image != ""){
            $image_path=public_path('images/services').'/'.$services->image;
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $imagename = rand(0000,9999).$request->image->getclientoriginalname();
            $request->image->move(public_path('images/services'),$imagename);
            $Services['image'] = $imagename;
           }

           Services::whereId($id)->update($Services);

        return redirect()->route("services.index")->with("success", "Services updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $services = Services::find($id);         
        File::delete(public_path('images/services'. '/'.$services->image));
        if(Services::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
    
    public function check_title_exists_service(Request $request)
    {
        $rules = [
            'title'=> 'required|unique:services,title',
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
    public function check_title_edit_exists_service(Request $request)
    {
        $rules = [
            'title'=> 'required|unique:services,title,'.$request->id,
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
