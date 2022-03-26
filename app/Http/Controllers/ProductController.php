<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\User;
use App\Models\ProductImage;
use App\Models\ProductAttribute;
use DB;
use Auth;
use DataTables;
use Picqer\Barcode\Picqer\Barcode\BarcodeGeneratorPNG;
use Shopify\Clients\Rest;

class ProductController extends Controller
{
    public function list(Request $request){
        if(!Auth::user()->can('product-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        if ($request->ajax()) {
            $Product = new Product;
            $Product = $Product->with(['product_image']);
            
            if(auth()->user()->type == '2'){
                $Product = $Product->where('user_id', auth()->user()->id);
            }

            if($request->category != ""){
                $Product = $Product->whereRaw('json_contains(category_id, \'["' . $request->category . '"]\')');
            }

            if($request->status != ""){
                $Product = $Product->where('status', $request->status);
            }

            if($request->sort_by != ""){
                $Product =  $Product->orderBy('created_at', $request->sort_by);
            } else {
                $Product =  $Product->orderBy('created_at', "desc");
            }

            $Product = $Product->get();
            
            return Datatables::of($Product)
                    ->addIndexColumn()
                    ->addColumn('category', function($row){
                       
                        $Category = Category::whereIn("id", $row->category_id)->get()->pluck("name")->toArray();
                        $Category = implode(", ",$Category);
                        return $Category;
                    })
                    ->editColumn('id', function($row){
                        return str_pad($row->id, 6, '0', STR_PAD_LEFT);
                    })
                    ->editColumn('supplier_name', function($row){
                        return $row->supplier ? $row->supplier->name : "";
                    })
                    ->editColumn('barcode', function($row){
                        $generatorPNG = new \Picqer\Barcode\BarcodeGeneratorPNG();
                        return '<img src="data:image/png;base64,'.base64_encode($generatorPNG->getBarcode($row->barcode, $generatorPNG::TYPE_CODE_128)).' "><br>' . $row->barcode;
                    })
                    ->addColumn('image', function($row){
                        $product_image = $row->product_image ? $row->product_image->image : "";
                        return '<img src="'.url('product/' . $product_image) .'" width="100px">';
                    })
                    ->addColumn('sync', function($row){
                        $sync = "";
                        if($row->shopify_sync == 1){
                            $sync .= "Shopify";
                        }
                        return $sync;
                    })
                    ->editColumn('status', function($row){
                        if(auth()->user()->type == '1'){
                            $html = '<select class="form-control status select2">';
                            $selected = $row->status == 'Pending' ? 'selected' : '';
                            $html .= '<option '. $selected .' data-id="'. $row->id .'">Pending</option>';
                            $selected = $row->status == 'Approve' ? 'selected' : '';
                            $html .= '<option '. $selected .' data-id="'. $row->id .'">Approve</option>';
                            $selected = $row->status == 'Reject' ? 'selected' : '';
                            $html .= '<option '. $selected .' data-id="'. $row->id .'">Reject</option>';
                            $html .= '</select>';
                            return $html;
                        } else {
                            return $row->status;
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                        if(Auth::user()->can('product-edit')){
                            $btn .= '<a href="'. route('products.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('product-delete') && auth()->user()->type == '1'){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('products.delete', $row->id) .'" class="delete_btn btn btn-danger btn-sm" data-id="'. $row->id .'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }

                        $btn .= '<a href="'. route('products_attribute', $row->id) .'" class="edit btn btn-primary btn-sm m-1">Attribute</a>';

                        return $btn;
                    })
                    ->rawColumns(['action','barcode', 'image', 'category', 'status', 'sync'])
                    ->make(true);
        }

        $Category = Category::get();
        return view('admin.products.list', compact('Category'));
    }

    public function create(){
        if(!Auth::user()->can('product-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $Category = Category::get();
        $Attribute = Attribute::get();
        $Supplier = User::where("type", 2)->get();

        return view('admin.products.create', compact('Category','Attribute','Supplier'));
    }

    public function store(Request $request)
    {
        if(!Auth::user()->can('product-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $Attribute = Attribute::get();

        $last_id = 1;
        $Product = Product::latest('id')->first();
        if(!empty($Product)){
            $last_id += $Product->id;
        }

        if(auth()->user()->type == 1){
            $User = User::where("id", $request->supplier_id)->first();
            $sku = $User->code . $last_id;
            $supplier_name = $User->name;
            $supplier_id = $request->supplier_id;
        } else {
            $sku = auth()->user()->code . $last_id;
            $supplier_name = auth()->user()->name;
            $supplier_id = auth()->user()->id;
        }

        $Product = array(
            "user_id" => auth()->user()->id,
            "supplier_id" => $supplier_id,
            "barcode" => rand(0000, 9999) . time(),
            "name" => $request->name,
            "sku" => $sku,
            "description" => $request->description,
            "quantity" => $request->quantity,
            "supplier_name" => $supplier_name,
            "cost_of_good" => $request->cost_of_good,
            "retail_price" => $request->retail_price,
            "product_type" => $request->product_type,
            "product_status" => $request->product_status,
            "expected_date" => date('Y-m-d', strtotime($request->expected_date)),
            "received_date" => date("Y-m-d", strtotime($request->received_date)),
            "delivery_date" => date("Y-m-d", strtotime($request->delivery_date)),
            "category_id" => json_encode($request->category_id),
            "attribute_id" => json_encode($request->attribute_id),
        );

        $product = Product::create($Product);
        
        foreach($request->upload_images as $upload_images){
            
            $fileName = rand(0000,9999) . time().'.'.$upload_images->extension();  
   
            $upload_images->move(public_path('product'), $fileName);
            $ProductImage = array(
                "product_id" => $product->id,
                "image" => $fileName,
            );

            ProductImage::create($ProductImage);
        }

        $request->request->remove('name');
        $request->request->remove('sku');
        $request->request->remove('description');
        $request->request->remove('quantity');
        $request->request->remove('cost_of_good');
        $request->request->remove('retail_price');
        $request->request->remove('expected_date');
        $request->request->remove('received_date');
        $request->request->remove('category_id');
        $request->request->remove('attribute_id');
        $request->request->remove('upload_images'); 
        $request->request->remove('_token');
        $request_all = $request->all();

        unset($request_all["upload_images"]);
        
        if(isset($request_all['supplier_price'])){
            foreach($request_all['supplier_price'] as $key => $value ){
                foreach($Attribute as $item){
                    if (array_key_exists($item->name,$request_all))
                    {
                        $data[$item->name] = $request_all[$item->name][$key];
                    }
                }
                $data['supplier_price'] = $value;
                $data['admin_price'] = $request_all['admin_price'][$key];
                $data['supplier_sku'] = $request_all['supplier_sku'][$key];
                $data['admin_sku'] = $request_all['admin_sku'][$key];
                $data['supplier_quantity'] = $request_all['supplier_quantity'][$key];
                $data['admin_quantity'] = $request_all['admin_quantity'][$key];
    
                $ProductAttribute = array(
                    "product_id" => $product->id,
                    "attributes" => json_encode($data),
                );
    
                ProductAttribute::create($ProductAttribute);
            }
        }

        return redirect()->route('products')
                        ->with('success','Product created successfully');
    }

    public function edit(Request $request, $id){
        if(!Auth::user()->can('product-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }

        $Attribute = Attribute::get();
        $Product = Product::find($id);
        $Category = Category::get();
        $Supplier = User::where("type", 2)->get();

        return view('admin.products.edit', compact('Product', 'Category', 'Attribute', 'Supplier'));
    }

    public function update(Request $request, $id)
    {
        
        $Attribute = Attribute::get();

        if(!Auth::user()->can('product-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $Product = array(
            "name" => $request->name,
            "description" => $request->description,
            "quantity" => $request->quantity,
            "cost_of_good" => $request->cost_of_good,
            "retail_price" => $request->retail_price,
            "product_type" => $request->product_type,
            "product_status" => $request->product_status,
            "expected_date" => date('Y-m-d', strtotime($request->expected_date)),
            "received_date" => date("Y-m-d", strtotime($request->received_date)),
            "delivery_date" => date("Y-m-d", strtotime($request->delivery_date)),
            "product_status" => $request->product_status,
            "category_id" => json_encode($request->category_id),
            "attribute_id" => json_encode($request->attribute_id),
        );

        $product = Product::whereId($id)->update($Product);
        
        if($request->hasFile('upload_images')){
            foreach($request->upload_images as $upload_images){

                $fileName = rand(0000,9999) . time().'.'.$upload_images->extension();  
       
                $upload_images->move(public_path('product'), $fileName);
                $ProductImage = array(
                    "product_id" => $id,
                    "image" => $fileName,
                );
    
                ProductImage::create($ProductImage);
            }
        }

        $request->request->remove('name');
        $request->request->remove('sku');
        $request->request->remove('description');   
        $request->request->remove('quantity');
        $request->request->remove('cost_of_good');
        $request->request->remove('retail_price');
        $request->request->remove('expected_date');
        $request->request->remove('received_date');
        $request->request->remove('category_id');
        $request->request->remove('attribute_id');
        $request->request->remove('upload_images'); 
        $request->request->remove('_token');
        $request_all = $request->all();

        unset($request_all["upload_images"]);
        
        ProductAttribute::where("product_id", $id)->delete();
        if(isset($request_all['supplier_price'])){
            foreach($request_all['supplier_price'] as $key => $value ){
                foreach($Attribute as $item){
                    if (array_key_exists($item->name,$request_all))
                    {
                        $data[$item->name] = $request_all[$item->name][$key];
                    }
                }
    
                $data['supplier_price'] = $value;
                $data['admin_price'] = $request_all['admin_price'][$key];
                $data['supplier_sku'] = $request_all['supplier_sku'][$key];
                $data['admin_sku'] = $request_all['admin_sku'][$key];
                $data['supplier_quantity'] = $request_all['supplier_quantity'][$key];
                $data['admin_quantity'] = $request_all['admin_quantity'][$key];
    
                $ProductAttribute = array(
                    "product_id" => $id,
                    "attributes" => json_encode($data),
                );
    
                ProductAttribute::create($ProductAttribute);
            }
        }
        
        return redirect()->route('products')->with('success','Product updated successfully');
    }

    public function product_image_delete(Request $request){
        $ProductImage = ProductImage::whereId($request->id)->first();

        if(file_exists(public_path('product/'.$ProductImage->image))){
            unlink(public_path('product/'.$ProductImage->image));
        }
        $ProductImage = ProductImage::where('id', $request->id)->delete();

        if($ProductImage){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }

    public function delete(Request $request, $id){
        if(Product::where("id", $id)->delete()){

            $ProductImage = ProductImage::where("product_id", $id)->get();
            foreach($ProductImage as $item){
                if(file_exists(public_path('product/'.$item->image))){
                    unlink(public_path('product/'.$item->image));
                }
            }

            ProductImage::where("product_id", $id)->delete();
            ProductAttribute::where("product_id", $id)->delete();

            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }

    public function products_change_status(Request $request){

        if($request->status == "Approve"){
            $Product = Product::whereId($request->id)->first();

            $User = User::whereId($Product->user_id)->first()->toArray();

            $data = array(
                "product_name" => $Product->name,
                "name" => $User["name"],
                "email" => $User["email"],
            );
            \Mail::to($User["email"])->send(new \App\Mail\ProductApproveMail($data));

            \LogActivity::addToLog('Product ' .$User["name"]. ' Was Approved.', $request->id);
        }

        if($request->status == "Reject"){
            $Product = Product::whereId($request->id)->first();

            $User = User::whereId($Product->user_id)->first()->toArray();

            $data = array(
                "product_name" => $Product->name,
                "name" => $User["name"],
                "email" => $User["email"],
            );
            \Mail::to($User["email"])->send(new \App\Mail\ProductRejectMail($data));

            \LogActivity::addToLog('Product ' .$User["name"]. ' Was Rejected.', $request->id);
        }

        if(Product::whereId($request->id)->update(["status" => $request->status])){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }

    public function products_attribute(Request $request, $id){
        $ProductAttribute = ProductAttribute::where("product_id", $id)->get();
        return view('admin.products.products_attribute', compact('ProductAttribute'));
    }

    public function product_add_to_shopify(Request $request, $id){
        $Product = Product::where("id", $id)->first();

        $Category = Category::whereIn("id", $Product->category_id)->get()->pluck("name")->toArray();
    
        $url = 'https://artisan11.myshopify.com/admin/api/2021-10/products.json';
        
        $ch = curl_init($url);
        
        $data['product'] = [
            "title" => $Product->name,
            "body_html" => $Product->description,
            "vendor" => "Burton",
            "product_type" => $Product->product_type,
            "tags" => $Category
        ];

        $data = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'X-Shopify-Access-Token: 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'
        ));
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($ch);
        $result = json_decode($result);

        if(!empty($result) && isset($result->product) && isset($result->product->id)){
            Product::where("id", $id)->update(['shopify_sync' => 1]);
        }

        curl_close($ch);

        return back()->with('success','Product sync successfully');

    }

    public function check_name_exists_in_products(Request $request){
        $Product = new Product;
        if($request->id != ""){
            $Product = $Product->where("id", "!=", $request->id); 
        }
        $Product = $Product->where("name", $request->name);
        $Product = $Product->first();

        if(!empty($Product)){
            $res = ["status" => 0, "message" => "This product name is already exists."];
        } else {
            $res = ["status" => 1];
        }
        return $res;
    }
}
