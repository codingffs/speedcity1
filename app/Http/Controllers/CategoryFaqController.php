<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoryfaq;
use App\Models\Categorysubfaq;
use DB;
use Auth;
use DataTables;
use File;

class CategoryFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('faq-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $faq = Categoryfaq::latest()->get();
            
            return Datatables::of($faq)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('faq-edit')){
                            $btn .= '<a href="'. route('faq.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('faq-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('faq.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.categoryfaq.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('faq-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        return view('admin.categoryfaq.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('faq-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:categoryfaqs',
        ]);
        $faq = array(
            "title" => $request->title,
        );
        Categoryfaq::create($faq);

        return redirect()->route("faq.index")->with("success", "Faq created successfully.");
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
        if(!Auth::user()->can('faq-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $faq = Categoryfaq::find($id);

        return view('admin.categoryfaq.edit', compact('faq'));
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
        $faq = Categoryfaq::find($id);
        if(!Auth::user()->can('faq-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:categoryfaqs,title,'.$id,
        ]);
        $faq = array(
            "title" => $request->title,
        );
        Categoryfaq::whereId($id)->update($faq);

        return redirect()->route("faq.index")->with("success", "Faq updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = Categoryfaq::find($id);
        $subfaq = Categorysubfaq::where('faq_id',$id)->delete();         
        if(Categoryfaq::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
