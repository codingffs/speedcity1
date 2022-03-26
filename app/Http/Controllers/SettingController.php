<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use DB;
use Auth;
use DataTables;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('setting-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $Setting = Setting::select('*')->latest();
            return Datatables::of($Setting)
                    ->addIndexColumn()
                    ->editColumn('value', function($row){
                        if($row->type == "File"){
                            return '<img src="'. asset('setting/' . $row->value) .'" width="100px">';
                        } else {
                            return $row->value;
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = "";

                        if(Auth::user()->can('setting-edit')){
                            $btn .= '<a href="'. route('settings.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('setting-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('settings.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm" data-id="'. $row->id .'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action', 'value', 'status'])
                    ->make(true);
        }

        return view('admin.setting.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('setting-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        return view('admin.setting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('setting-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $request->validate([
            'key' => 'required|unique:settings'
        ]);
        
        if($request->type == "File"){
            $value = rand(0000,9999) . time().'.'.$request->value->extension();  
            $request->value->move(public_path('setting'), $value);
        } else {
            $value = $request->value;
        }

        $Setting = array(
            "title" => $request->title,
            "type" => $request->type,
            "key" => $request->key,
            "value" => $value,
        );

        Setting::create($Setting);
    
        return redirect()->route('settings.index')
                        ->with('success','Setting created successfully');
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
        if(!Auth::user()->can('setting-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $Setting = Setting::find($id);
        return view('admin.setting.edit',compact('Setting'));
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
        if(!Auth::user()->can('setting-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $request->validate([
            'key' => 'required|unique:settings,key,'.$id
        ]);

        if($request->type == "File"){
            if($request->value != ""){
                $value = rand(0000,9999) . time().'.'.$request->value->extension();  
                $request->value->move(public_path('setting'), $value);
            } else {
                $value = $request->old_value;
            }
        } else {
            $value = $request->value;
        }

        $Setting = array(
            "title" => $request->title,
            "key" => $request->key,
            "value" => $value,
        );

        Setting::whereId($id)->update($Setting);
    
        return redirect()->route('settings.index')
                        ->with('success','Setting updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Setting = Setting::whereId($id)->first();
        if($Setting->type == "File"){
            if(file_exists(public_path('setting/'.$Setting->value))){
                unlink(public_path('setting/'.$Setting->value));
            }
        }

        $Setting = Setting::whereId($id)->delete();
        if($Setting){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
