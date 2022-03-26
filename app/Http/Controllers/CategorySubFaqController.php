<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorysubfaq;
use App\Models\Categoryfaq;
use DB;
use Auth;
use DataTables;
use File;

class CategorySubFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('subfaq-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $subfaq = Categorysubfaq::latest()->get();
            
            return Datatables::of($subfaq)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->editColumn('faq_id',function($row){
                        return getFaqname($row->faq_id); 
                    })
                    ->editcolumn('description', function($row){
                        $des = $row->description;
                        return $des;
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('subfaq-edit')){
                            $btn .= '<a href="'. route('subfaq.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-5" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('subfaq-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('subfaq.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm m-5" data-id="'. $row->id .'" ><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action','description'])
                    ->make(true);
        }
        
        return view('admin.categorysubfaq.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('subfaq-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $faq = Categoryfaq::get();
        return view('admin.categorysubfaq.create',compact('faq'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('subfaq-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:categorysubfaqs',
        ]);
        $subfaq = array(
            "faq_id" => $request->faq_id,
            "title" => $request->title,
            "description" => $request->description,
        );
        Categorysubfaq::create($subfaq);

        return redirect()->route("subfaq.index")->with("success", "SubFaq created successfully.");
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
        if(!Auth::user()->can('subfaq-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $subfaq = Categorysubfaq::find($id);
        $faq = Categoryfaq::get();

        return view('admin.categorysubfaq.edit', compact('subfaq','faq'));
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
        $subfaq = Categorysubfaq::find($id);
        if(!Auth::user()->can('subfaq-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $request->validate([
            'title' => 'required|unique:categorysubfaqs,title,'.$id,
        ]);
        $subfaq = array(
            "faq_id" => $request->faq_id,
            "title" => $request->title,
            "description" => $request->description,
        );
        Categorysubfaq::whereId($id)->update($subfaq);

        return redirect()->route("subfaq.index")->with("success", "SubFaq updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Categorysubfaq::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
