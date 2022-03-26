<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use DB;
use Auth;
use DataTables;

class CountryController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('country-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $Country = Country::get();
            return Datatables::of($Country)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('country-edit')){
                            $btn .= '<a href="'. route('country.edit', $row->country_id) .'" class="edit btn btn-primary btn-sm m-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('country-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('country.destroy', $row->country_id) .'" class="delete_btn btn btn-danger btn-sm" data-id="'. $row->country_id .'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.country.list');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('country-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        return view('admin.country.create');
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
            if(!Auth::user()->can('country-create')){
                return back()->with(['error' => 'Unauthorized Access.']);
            }
    
            $request->validate([
                'country_name' => 'required|unique:countries,country_name',
            ]);
            
            $country = array(
                "country_name" => $request->country_name,
                "sortname" => $request->sortname,
            );
    
            $data_user = Country::create($country);
            
            return redirect()->route('country.index')->with('success','Country created successfully.');
        // } catch (\Throwable $th) {
        //     return redirect()->back()->with('error', $th->getMessage());
        // }
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $country_id
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
    public function edit($country_id)
    {
        if(!Auth::user()->can('country-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $Country = Country::find($country_id);
    
        return view('admin.country.edit',compact('Country'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $country_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $country_id)
    {
        if(!Auth::user()->can('country-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        
        $Country = array(
            "country_name" => $request->country_name,
            "sortname" => $request->sortname,
        );
        
        Country::where('country_id',$country_id)->update($Country);
    
        return redirect()->route('country.index')->with('success','Country updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $country_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($country_id)
    {
        if(!Auth::user()->can('country-delete')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        
        if(Country::where('country_id',$country_id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
    public function check_country_exists_update(Request $request)
    {
        $Country = Country::where('country_id',$request->country_id)->where('country_name',$request->country_name)->exists();
        if($Country == true){
            return response()->json(['status' => '0']);
        }
        else{
            $Country = Country::where('country_name',$request->country_name)->exists();
            if($Country == true){
                return response()->json(['status' => '1','message' => 'Country Already Exists! ']);
            }
            else{
                return response()->json(['status' => '0']);
            }
        }
    }
}
