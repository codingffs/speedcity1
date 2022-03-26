<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity as LogActivityModel;
use Auth;
use DataTables;

class ActivityLogController extends Controller
{
    public function list(Request $request){
        if(!Auth::user()->can('activity-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $logs = \LogActivity::logActivityLists();
          
            return Datatables::of($logs)
                    ->addIndexColumn()
                    ->addColumn('action_by', function($row){
                        return $row->user ? $row->user->name : "";
                    })
                    ->editColumn('created_at', function($row){
                        return date("l, d F Y", strtotime($row->created_at));
                    })
                    ->rawColumns(['action_by', 'created_at'])
                    ->make(true);
        }
        
        return view('admin.activity.list');
    }
}
