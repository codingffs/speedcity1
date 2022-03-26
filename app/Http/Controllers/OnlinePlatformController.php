<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OnlinePlatform;
use Auth;

class OnlinePlatformController extends Controller
{

    public function index(Request $request){
        if(!Auth::user()->can('online_platform')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $OnlinePlatform = OnlinePlatform::first();
        return view('admin.online_platform.index', compact('OnlinePlatform'));
    }

    public function store(Request $request){
        if(!Auth::user()->can('online_platform')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        
        $OnlinePlatform = OnlinePlatform::first();

        $data = array(
            "shopify" => $request->shopify,
            "facebook" => $request->facebook,
            "instagram" => $request->instagram,
            "po_for_individual" => $request->po_for_individual,
            "po_for_supplier" => $request->po_for_supplier,
        );

        if(!empty($OnlinePlatform)){
            OnlinePlatform::whereId($OnlinePlatform->id)->update($data);
        } else {
            OnlinePlatform::insert($data);
        }

        return back()->with(['success' => 'Sync platform save successfully.']);
    }
}
