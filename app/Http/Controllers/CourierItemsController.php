<?php
// namespace App\Http\Controllers\API\Admin;
namespace App\Http\Controllers;



use Illuminate\Http\Request;
// use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\CourierItems;
use DB;
use Auth;
use DataTables;

class CourierItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CourierItems::get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                        $btn = "";
                            $btn .= '<a href="'. route('Courierlist.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('Courierlist.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm" data-id="'. $row->id .'"><i class="fa fa-trash" aria-hidden="true"></i></a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.courier.list');
    }

   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.courier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();   
        
        $validator = Validator::make($input, [
            'item_name' => 'required',
            'description' => 'required'
        ]);   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());      
        }   
        $obj = CourierItems::create([
            'item_name' => $input['item_name'],
            'description' => $input['description'],
            'slug' => \Str::slug($request->item_name),
        ]); 
        return redirect()->route("Courierlist.index")->with("success", "Courierlist Item created successfully.");
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
     * @param  \App\pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $CourierItems = CourierItems::find($id);

        return view('admin.courier.edit', compact('CourierItems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'item_name' => 'required',
            'description' => 'required',
        ]);   
        if($validator->fails()){
           
        return redirect()->route("Courierlist.index")->with("error", "Something Went wrong!.");
        }   
                                
        $id = $input['id'];
        
        $obj = CourierItems::where('id', $id)->update([
            'item_name' => $input['item_name'],
            'description' => $input['description'],
            'slug' => \Str::slug($request->item_name),

        ]);
        return redirect()->route("Courierlist.index")->with("success", "Item updated successfully.");
           
        return $this->sendResponse($obj, 'Item updated successfully.');
    }
    // public function updateContent(Request $request)
    // {
    //     $input = $request->all();   
                        
    //     $validator = Validator::make($input, [
    //         'content' => 'required'
    //     ]);   
    //     if($validator->fails()){
    //         return $this->sendError('Validation Error.', $validator->errors());      
    //     }   
    //     $id = $input['id'];
    //     $obj = CourierItems::where('id', $id)->update([
    //         'content' => json_encode($input['content'])
    //     ]);
    //     // Category::whereId($id)->update($Category);

    //     return redirect()->route("Courierlist.index")->with("success", "Item updated successfully.");
           
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $CourierItems = CourierItems::find($id);   
        if(CourierItems::whereId($id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
}
