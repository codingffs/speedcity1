<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use DB;
use Auth;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $User = User::get();
            return Datatables::of($User)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = "";
                            // $btn .= '<a href="'. route('user.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                            // $btn .= '<a href="javascript:void(0)" data-url="'. route('user.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm" data-id="'. $row->id .'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.user.list');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if(!Auth::user()->can('user-create')){
        //     return back()->with(['error' => 'Unauthorized Access.']);
        // }

        // $Role = Role::get();

        return view('admin.user.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|unique:users',
            ]);
            $hash_password = bcrypt($request->password);
            $User = array(
                "name" => $request->name,
                "email" => $request->email,
                "password" => $hash_password,
            );
            
            $data_user = User::create($User);
            // \Mail::to($request->email)->send(new \App\Mail\CreateUserMail($User));
            // $data_user->assignRole([$request->type]);
            return redirect()->route('user.index')->with('success','User created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $role = Role::find($id);
        // $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        //     ->where("role_has_permissions.role_id",$id)
        //     ->get();
    
        // return view('roles.show',compact('role','rolePermissions'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->can('user-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $Role = Role::get();
        $User = User::find($id);
    
        return view('admin.user.edit',compact('Role','User'));
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
        if(!Auth::user()->can('user-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $User = array(
            "name" => $request->name,
            "phone" => $request->phone,
            "address" => $request->address,
            "type" => $request->type,
        );

        User::whereId($id)->update($User);
    
        return redirect()->route('user.index')->with('success','User updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->can('user-delete')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        
        if(User::where('id',$id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
