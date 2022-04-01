<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\MedicalAppliance;
use DB;
use Auth;
use DataTables;
use File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $Category = Category::latest()->get();
            
            return Datatables::of($Category)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->editcolumn('image', function($row){
                        $url = url("/images/category"."/".$row->image);        
                        return '<img src="'. $url .'" height="80" weight="80"/>';
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('category-edit')){
                            $btn .= '<a href="'. route('categories.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('category-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('categories.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
        }
        
        return view('admin.category.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'image' => 'required',
        ]);
        $imagename = rand(0000,9999).$request->image->getclientoriginalname();
        $request->image->move(public_path('images/category'),$imagename);
        $path = url('images/category',$imagename);
        $Category = array(
            "title" => $request->title,
            "image" => $imagename,
        );

        Category::create($Category);

        return redirect()->route("categories.index")->with("success", "Banner created successfully.");
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
        $Category = Category::find($id);

        return view('admin.category.edit', compact('Category'));
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
        $category = Category::find($id);
        
        $Category = array(
            "title" => $request->title,
        );
        if(isset($request->image) && !empty($request->image)){
            if(isset($category->image) && $category->image != ""){
            $image_path=public_path('images/category').'/'.$category->image;
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $imagename = rand(0000,9999).$request->image->getclientoriginalname();
            $request->image->move(public_path('images/category'),$imagename);
            $Category['image'] = $imagename;
           }

        Category::whereId($id)->update($Category);

        return redirect()->route("categories.index")->with("success", "Banner updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);  
        $medicalappliance = MedicalAppliance::where('cat_id',$id)->delete();       
        File::delete(public_path('images/category'. '/'.$category->image));
        if(Category::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
