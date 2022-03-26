<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;
use DB;
use Auth;
use DataTables;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('state-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $State = State::get();
            return Datatables::of($State)
            ->addIndexColumn()
            ->editColumn('country_id',function($row){
                return getcountryname($row->country_id); 
            })
            ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('state-edit')){
                            $btn .= '<a href="'. route('state.edit', $row->state_id) .'" class="edit btn btn-primary btn-sm m-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('state-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('state.destroy', $row->state_id) .'" class="delete_btn btn btn-danger btn-sm" data-id="'. $row->state_id .'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','country_id'])
                    ->make(true);
        }

        return view('admin.state.list');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('state-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $country = Country::get();
        return view('admin.state.create',compact('country'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // try {
            if(!Auth::user()->can('state-create')){
                return back()->with(['error' => 'Unauthorized Access.']);
            }
    
            $request->validate([
                'state_name' => 'required|unique:states',
            ]);
            
            $State = array(
                "state_name" => $request->state_name,
                "country_id" => $request->country_id,
            );
    
            $data_user = State::create($State);
            
            return redirect()->route('state.index')->with('success','State created successfully.');
        // } catch (\Throwable $th) {
        //     return redirect()->back()->with('error', $th->getMessage());
        // }
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $state_id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($state_id)
    {
        if(!Auth::user()->can('state-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $State = State::find($state_id);
        $country = Country::get();
    
        return view('admin.state.edit',compact('State','country'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $state_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $state_id)
    {
        if(!Auth::user()->can('state-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $State = array(
            "state_name" => $request->state_name,
            "country_id" => $request->country_id,
        );
        
        State::where('state_id',$state_id)->update($State);
    
        return redirect()->route('state.index')->with('success','State updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $state_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($state_id)
    {
        if(!Auth::user()->can('state-delete')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        
        if(State::where('state_id',$state_id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
    public function check_state_exists_in_country(Request $request)
    {
        $state = State::where('state_name',$request->state_name)->where('country_id',$request->country_id)->exists();
        if($state == true){
            return response()->json(['status' => '1','message' => 'State Already Exists!']);
        }
        else{
            return response()->json(['status' => '0']);
        }
    }
    public function check_state_exists_in_update(Request $request)
    {
        $state = State::where('state_id',$request->state_id)->where('state_name',$request->state_name)->where('country_id',$request->country_id)->exists();
        if($state == true){
            return response()->json(['status' => '0']);
        }
        else{
            $state = State::where('state_name',$request->state_name)->where('country_id',$request->country_id)->exists();
            if($state == true){
                return response()->json(['status' => '1','message' => 'State Already Exists! ']);
            }
            else{
                return response()->json(['status' => '0']);
            }
        }
    }
}
