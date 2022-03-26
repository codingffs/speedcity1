<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use DB;
use Auth;
use DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('permission-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $Permission = Permission::select('*')->latest();
            return Datatables::of($Permission)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('permission-edit')){
                            $btn .= '<a href="'. route('permission.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('permission-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('permission.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm" data-id="'. $row->id .'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }

        return view('admin.permission.list');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('permission-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        return view('admin.permission.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('permission-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $this->validate($request, [
            'name' => 'required|unique:permissions',
        ]);

        Permission::create(['name' => $request->input('name')]);
    
        return redirect()->route('permission.index')
                        ->with('success','Permission created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return view('roles.show',compact('role','rolePermissions'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->can('permission-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $Permission = Permission::find($id);
    
        return view('admin.permission.edit',compact('Permission'));
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
        if(!Auth::user()->can('permission-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $this->validate($request, [
            'name' => 'required|unique:permissions,name,'.$id,
        ]);
    
        Permission::whereId($id)->update(['name' => $request->name]);

        return redirect()->route('permission.index')
                        ->with('success','Permission updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->can('permission-delete')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        if(Permission::where('id',$id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }

}
