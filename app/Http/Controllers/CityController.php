<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use DB;
use Auth;
use DataTables;

class CityController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('city-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $City = City::get();
            return Datatables::of($City)
            ->addIndexColumn()
            ->editColumn('state_id',function($row){
                return getstatename($row->state_id); 
            })
            ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('city-edit')){
                            $btn .= '<a href="'. route('city.edit', $row->city_id) .'" class="edit btn btn-primary btn-sm m-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('city-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('city.destroy', $row->city_id) .'" class="delete_btn btn btn-danger btn-sm" data-id="'. $row->city_id .'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','state_id'])
                    ->make(true);
        }

        return view('admin.city.list');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('city-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $state = State::get();
        return view('admin.city.create',compact('state'));
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
            if(!Auth::user()->can('city-create')){
                return back()->with(['error' => 'Unauthorized Access.']);
            }
    
            $request->validate([
                'city_name' => 'required',
            ]);
            
            $City = array(
                "city_name" => $request->city_name,
                "state_id" => $request->state_id,
            );
    
            $data_user = City::create($City);
            
            return redirect()->route('city.index')->with('success','City created successfully.');
        // } catch (\Throwable $th) {
        //     return redirect()->back()->with('error', $th->getMessage());
        // }
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $city_id
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
    public function edit($city_id)
    {
        if(!Auth::user()->can('city-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $City = City::find($city_id);
        $state = State::get();
    
        return view('admin.city.edit',compact('City','state'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $city_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $city_id)
    {
        if(!Auth::user()->can('city-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $City = array(
            "city_name" => $request->city_name,
            "state_id" => $request->state_id,
        );
        
        City::where('city_id',$city_id)->update($City);
    
        return redirect()->route('city.index')->with('success','City updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $city_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($city_id)
    {
        if(!Auth::user()->can('city-delete')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        
        if(City::where('city_id',$city_id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
    public function check_city_exists_in_state(Request $request)
    {
        $state = State::find($request->state_id);
        $city = City::where('city_name',$request->city_name)->where('state_id',$request->state_id)->exists();
        if($city == true){
            return response()->json(['status' => '1','message' => 'City Already Exists!']);
        }
        else{
            return response()->json(['status' => '0']);
        }
    }
    public function check_city_exists_in_update(Request $request)
    {
        $state = State::find($request->state_id);
        $city = City::where('city_id',$request->city_id)->where('city_name',$request->city_name)->where('state_id',$request->state_id)->exists();
        if($city == true){
            return response()->json(['status' => '0']);
        }
        else{
            $city = City::where('city_name',$request->city_name)->where('state_id',$request->state_id)->exists();
            if($city == true){
                return response()->json(['status' => '1','message' => 'City Already Exists! ']);
            }
            else{
                return response()->json(['status' => '0']);
            }
        }
    }
    
}
