<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Auth;

class SupplierController extends Controller
{
    public function list(Request $request){

        if(!Auth::user()->can('supplier-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $data = new User;
            $data = $data->select('*')->whereType('2');
            if(isset($request->status) && $request->status != '' && $request->status != "all") {
                $data = $data->where('status', $request->status);
            }
            $data = $data->latest();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->addColumn('status', function($row){
                        if($row->status == "Pending"){
                            $btn = '<a href="javascript:void(0)" data-url="'. route('suppliers.approve', $row->id) .'" data-id="'. $row->id .'" class="approve_btn btn btn-primary btn-sm mb-1"><i class="fa fa-check" aria-hidden="true"></i></a><br>';
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('suppliers.reject', $row->id) .'" data-id="'. $row->id .'" class="reject_btn btn btn-danger btn-sm"><i class="fa fa-ban" aria-hidden="true"></i></a>';
                            return $btn;
                        } else if($row->status == "Approve"){
                            $btn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm mb-1"><i class="fa fa-check" aria-hidden="true"></i></a>';
                            return $btn;
                        } else {
                            $btn = '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm mb-1"><i class="fa fa-ban" aria-hidden="true"></i></a>';
                            return $btn;
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('supplier-edit')){
                            $btn = '<a href="'. route('suppliers.edit', $row->id) .'" class="edit btn btn-primary btn-sm mb-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><br>';
                        }
                        if(Auth::user()->can('supplier-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('suppliers.delete', $row->id) .'" class="delete_btn btn btn-danger btn-sm" data-id="'. $row->id .'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
        
        return view('admin.supplier.list');
    }

    public function edit(Request $request, $id){
        if(!Auth::user()->can('supplier-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $Supplier = User::find($id);

        return view('admin.supplier.edit', compact('Supplier'));
    }

    public function update(Request $request, $id){
        if(!Auth::user()->can('supplier-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $request->validate([
            'email' => 'required|email|unique:users,email,'.$id,
        ]);
        
        $Supplier = array(
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "address" => $request->address,
            "about_supplier" => $request->about_supplier,
            "joining_date" => date("Y-m-d", strtotime($request->joining_date)),
        );

        User::whereId($id)->update($Supplier);

        return redirect()->route("suppliers")->with("success", "Supplier updated successfully.");
    }

    public function approve($id){
        if(User::whereId($id)->update(["status" => "Approve"])){
            $User = User::whereId($id)->first()->toArray();
            \Mail::to($User["email"])->send(new \App\Mail\ApproveSupplierMail($User));

            \LogActivity::addToLog('New Supplier ' .$User["name"]. ' Was Approved.', $id);
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }

    public function reject($id){
        if(User::whereId($id)->update(["status" => "Reject"])){
            $User = User::whereId($id)->first()->toArray();
            \Mail::to($User["email"])->send(new \App\Mail\RejectSupplierMail($User));

            \LogActivity::addToLog('New Supplier ' .$User["name"]. ' Was Rejected.', $id);
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
        
    }

    public function delete($id){
        if(User::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
