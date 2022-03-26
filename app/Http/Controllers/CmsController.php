<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cms;
use DB;
use Auth;
use DataTables;
use File;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('cms-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $cms = Cms::latest()->get();
            
            return Datatables::of($cms)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->editcolumn('description', function($row){
                        $des = $row->description;
                        return $des;
                    })
                    ->editcolumn('image', function($row){
                        $url = url("/images/cms"."/".$row->image);        
                        return '<img src="'. $url .'" height="80" weight="80"/>';
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('cms-edit')){
                            $btn .= '<a href="'. route('cms.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('cms-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('cms.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action','image','description'])
                    ->make(true);
        }
        
        return view('admin.cms.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('cms-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        return view('admin.cms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('cms-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:cms',
        ]);
        
        $imagename = rand(0000,9999).$request->image->getclientoriginalname();
        $request->image->move(public_path('images/cms'),$imagename);
        $cms = array(
            "title" => $request->title,
            "description" => $request->description,
            "slugname" => \Str::slug($request->title),
            "image" => $imagename,
        );
        Cms::create($cms);

        return redirect()->route("cms.index")->with("success", "Cms created successfully.");
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
        if(!Auth::user()->can('cms-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $cms = Cms::find($id);

        return view('admin.cms.edit', compact('cms'));
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
        $cms = Cms::find($id);
        if(!Auth::user()->can('cms-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:cms,title,'.$id,
        ]);
        $Cms = array(
            "title" => $request->title,
            "description" => $request->description,
            "slugname" => \Str::slug($request->title),
        );
        if(isset($request->image) && !empty($request->image)){
            if(isset($cms->image) && $cms->image != ""){
                $image_path=public_path('images/cms').'/'.$cms->image;
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $imagename = rand(0000,9999).$request->image->getclientoriginalname();
            $request->image->move(public_path('images/cms'),$imagename);
            $Cms['image'] = $imagename;
        }
        Cms::whereId($id)->update($Cms);

        return redirect()->route("cms.index")->with("success", "Cms updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cms = Cms::find($id);         
        File::delete(public_path('images/cms'. '/'.$cms->image));
        if(Cms::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
