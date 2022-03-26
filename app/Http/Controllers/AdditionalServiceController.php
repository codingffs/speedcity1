<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Additionalservice;
use DB;
use Auth;
use DataTables;
use File;

class AdditionalServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('additionalservice-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $additionalservice = Additionalservice::latest()->get();
            
            return Datatables::of($additionalservice)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('additionalservice-edit')){
                            $btn .= '<a href="'. route('additionalservice.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('additionalservice-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('additionalservice.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.additionalservice.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('additionalservice-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        return view('admin.additionalservice.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('additionalservice-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:additionalservices',
            'price' => 'required',
        ]);
        $additionalservice = array(
            "title" => $request->title,
            "price" => $request->price,
        );
        Additionalservice::create($additionalservice);

        return redirect()->route("additionalservice.index")->with("success", "Additional Service created successfully.");
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
        if(!Auth::user()->can('additionalservice-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $additionalservice = Additionalservice::find($id);

        return view('admin.additionalservice.edit', compact('additionalservice'));
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
        $additionalservice = Additionalservice::find($id);
        if(!Auth::user()->can('additionalservice-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:additionalservices,title,'.$id,
            'price' => 'required',
        ]);
        $additionalservice = array(
            "title" => $request->title,
            "price" => $request->price,
        );
        Additionalservice::whereId($id)->update($additionalservice);

        return redirect()->route("additionalservice.index")->with("success", "Additional Service updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $additionalservice = Additionalservice::find($id);         
        if(Additionalservice::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
