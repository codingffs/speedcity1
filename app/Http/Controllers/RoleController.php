<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Auth;
use DataTables;


class RoleController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if(!Auth::user()->can('role-list')){
        //     return back()->with(['error' => 'Unauthorized Access.']);
        // }

        if ($request->ajax()) {
            $Role = Role::select('*')->latest();
            return Datatables::of($Role)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = '<a href="'. route('roles.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        // $btn .= '<a href="javascript:void(0)" data-url="'. route('roles.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm" data-id="'. $row->id .'"><i class="fa fa-trash" aria-hidden="true"></i></a>';

                        return $btn;
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }

        $roles = Role::orderBy('id','DESC')->paginate(5);
        return view('admin.roles.list',compact('roles'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if(!Auth::user()->can('role-create')){
        //     return back()->with(['error' => 'Unauthorized Access.']);
        // }

        $permission = Permission::get();
        return view('admin.roles.create',compact('permission'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if(!Auth::user()->can('role-create')){
        //     return back()->with(['error' => 'Unauthorized Access.']);
        // }
        $this->validate($request, [
            'name' => 'required|unique:roles',
        ]);

        // echo "<pre>";
        // print_r($request->input('permission'));
        // exit;
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
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
        // if(!Auth::user()->can('role-edit')){
        //     return back()->with(['error' => 'Unauthorized Access.']);
        // }

        $Role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        return view('admin.roles.edit',compact('Role','permission','rolePermissions'));
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
        // if(!Auth::user()->can('role-edit')){
        //     return back()->with(['error' => 'Unauthorized Access.']);
        // }

        $this->validate($request, [
            'name' => 'required|unique:roles,name,'.$id,
        ]);
    
        Role::whereId($id)->update(["name" => $request->name]);

        $role = Role::find($id);
    
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if(!Auth::user()->can('role-delete')){
        //     return back()->with(['error' => 'Unauthorized Access.']);
        // }
        Role::where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }

}
