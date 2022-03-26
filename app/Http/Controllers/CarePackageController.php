<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarePackage;
use App\Models\PackagePlan;
use DB;
use Auth;
use DataTables;
use File;

class CarePackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('carepackage-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $carepackage = CarePackage::latest()->get();
            
            return Datatables::of($carepackage)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('carepackage-edit')){
                            $btn .= '<a href="'. route('carepackage.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('carepackage-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('carepackage.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.carepackage.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('carepackage-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        return view('admin.carepackage.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('carepackage-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:carepackages',
            'amount' => 'required',
            'validity' => 'required',
        ]);
        $carepackage = new CarePackage;
        $carepackage->title = $request->title;
        $carepackage->amount = $request->amount;
        $carepackage->validity = $request->validity;
        $carepackage->slugname = \Str::slug($request->title);
        $carepackage->save();
        $id = $carepackage->id;
        foreach ($request->field_title as $key => $value) {
            if(isset($value) && $value != ''){
            $packageplan = array(
                'package_id' => $id,
                'title' => $value
            );
            PackagePlan::create($packageplan);
            }
        }

        return redirect()->route("carepackage.index")->with("success", "Care Package Plan created successfully.");
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
        if(!Auth::user()->can('carepackage-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $carepackage = CarePackage::find($id);
        $packageplan = PackagePlan::where('package_id',$id)->get();
        return view('admin.carepackage.edit', compact('carepackage','packageplan'));
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
        $carepackage = CarePackage::find($id);
        if(!Auth::user()->can('carepackage-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:carepackages,title,'.$id,
            'amount' => 'required',
            'validity' => 'required',
        ]);
        //dd($request->all());
        $carepackage->title = $request->title;
        $carepackage->amount = $request->amount;
        $carepackage->validity = $request->validity;
        $carepackage->slugname = \Str::slug($request->title);
        $carepackage->update();
        $id = $carepackage->id;
        foreach ($request->field_title as $key => $value) {
            // if( $value != '[]'){
            $tile_array = array(
                'package_id' => $id,
                'title' => $value,
            );
            if(isset($request->field_id[$key]) && $request->field_id[$key] != '') {
                PackagePlan::where('id', $request->field_id[$key])->update($tile_array);
            } else {
                PackagePlan::create($tile_array);
            }
            // }
        }

        return redirect()->route("carepackage.index")->with("success", "Care Package Plan updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $packageplan = PackagePlan::where('package_id',$id)->get();
        PackagePlan::where('package_id',$id)->delete();
        if(CarePackage::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
    public function care_title_exists(Request $request)
    {
        $rules = [
            'title'=> 'required|unique:carepackages,title',
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
    public function care_title_exists_update(Request $request)
    {
        $rules = [
            'title'=> 'required|unique:carepackages,title,'.$request->id,
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

    public function remove_added_package(Request $request){
        $pakcageplan = PackagePlan::where('id',$request->id)->delete();
        return response()->json(["status" => "Plan Deleted Successfully"]);
    }
}
