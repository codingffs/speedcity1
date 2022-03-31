<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branchuser;
use DB;
use Auth;
use DataTables;
use File;

class BranchUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
          $Branchuser = Branchuser::get();
        if ($request->ajax()) {
            $BranchUser = Branchuser::get();
            
            return Datatables::of($BranchUser)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->editcolumn('image', function($row){
                        $url = url("/branchuser"."/".$row->image);        
                        return '<img src="'. $url .'" height="80" weight="80"/>';
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                            $btn .= '<a href="'. route('branchuser.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('branchuser.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
        }
        
        return view('admin.branchuser.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.branchuser.create');
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
            'branch_name' => 'required',
            'name' => 'required',
            'mobile' => 'required',
            'image' => 'required',
        ]);
        
        $imagename = rand(0000,9999).$request->image->getclientoriginalname();
        $request->image->move(public_path('/branchuser'),$imagename);
        $BranchUser = array(
            "branch_name" => $request->branch_name,
            "name" => $request->name,
            "mobile" => $request->mobile,
            "image" => $imagename,
        );

        Branchuser::create($BranchUser);

        return redirect()->route("branchuser.index")->with("success", "Branch User created successfully.");
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
             $BranchUser = Branchuser::find($id);
             return view('admin.branchuser.edit', compact('BranchUser'));
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
        $BranchUser = Branchuser::find($id);
        $request->validate([
            'branch_name' => 'required',
            'name' => 'required',
            'mobile' => 'required',
        ]);
        $imagename = $BranchUser->image;
        if(isset($request->image) && !empty($request->image)){
            if(isset($BranchUser->image) && $BranchUser->image != ""){
            $image_path=public_path('/branchuser').'/'.$BranchUser->image;
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $imagename = rand(0000,9999).$request->image->getclientoriginalname();
            $request->image->move(public_path('/branchuser'),$imagename);
            $BranchUser['image'] = $imagename;
           }
        $BranchUser = array(
            "branch_name" => $request->branch_name,
            "name" => $request->name,
            "mobile" => $request->mobile,
            "image" => $imagename
        );
       

        Branchuser::whereId($id)->update($BranchUser);

        return redirect()->route("branchuser.index")->with("success", "Branch User updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $BranchUser = Branchuser::find($id);  
        // $medicalappliance = MedicalAppliance::where('cat_id',$id)->delete();       
        File::delete(public_path('/branchuser'. '/'.$BranchUser->image));
        if(Branchuser::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
    // public function check_title_exists(Request $request)
    // {
    //     $rules = [
    //         'title'=> 'required|unique:categories,title',
    //     ];
    //     $validator = \Validator::make($request->all(), $rules);
    //     if ($validator->fails())
    //     {
    //         $res = [
    //             'message' => "Title Already Exists!",
    //             'status' => 0,
    //         ];
        
    //         return $res; 
    //     }
    //     $res = [
    //         'message' => 'success',
    //         'status' => 1,
    //     ];
    //     return $res;
    // }
    // public function check_title_exists_update(Request $request)
    // {
    //     $rules = [
    //         'title'=> 'required|unique:categories,title,'.$request->id,
    //     ];
    //     $validator = \Validator::make($request->all(), $rules);
    //     if ($validator->fails())
    //     {
    //         $res = [
    //             'message' => "Title Already Exists!",
    //             'status' => 0,
    //         ];
        
    //         return $res; 
    //     }
    //     $res = [
    //         'message' => 'success',
    //         'status' => 1,
    //     ];
    //     return $res;
    // }
}
