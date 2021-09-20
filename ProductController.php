<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){

        $products = DB::table('products')
            ->join('product_categories','product_categories.id','products.procate_id')
            ->get();
        return view('admin.products.index',compact('products'));
    }

    public function store(Request $request){

        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'product_name' => 'required|max:50',
            'category' => 'required',
        ]);

        if($validator->fails()){
            $data = array();
            $data['error'] = $validator->errors()->all();

            return response()->json([
                'success' => false,
                'data' => $data
            ]);
        }
        else{
            $product = Product::create([
                'product_name' => $request->product_name,
                'procate_id' => $request->category,
                
            ]);
            
            // $products = DB::table('products')
            // ->join('product_categories','product_categories.id','products.procate_id')
            // ->where('product_categories.id','products.procate_id')
            // ->get();
            $data = array();
            $data['message'] = "Data Added Successfully";
            $data['product_name'] = $product->product_name;
            $data['procate_name'] = $product->product_category->procate_name;
            $data['id'] = $product->id;
            // dd($data);
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        }


    }

    public function view(Request $request) {
        $product = Product::findOrFail($request->id);
        $data['product_name'] = $product->product_name;
        $data['procate_name'] = $product->product_category->procate_name;
        // dd($data);
        if ($data) {
            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data'    => 'No information found',
            ]);
        }
    }

    public function edit(Request $request) {
        $product = Product::findOrFail($request->id);

        
        $data['product_name'] = $product->product_name;
        $data['procate_id'] = $product->procate_id;
        $data['procate_name'] = $product->product_category->procate_name;
        $data['id'] = $product->id;
        // dd($data);
        if ($data) {
            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data'    => 'No information found',
            ]);
        }
    }

    public function update(Request $request, Product $product) {
        $validator = Validator::make($request->all(), [
            'product_name'        => 'required|max:50',
            'edit_category'        => 'required',
        ]);
        if ($validator->fails()) {
            $data          = array();
            $data['error'] = $validator->errors()->all();
            return response()->json([
                'success' => false,
                'data'    => $data,
            ]);
        } else {
            $product = Product::findOrFail($request->hidden_id);
            $product->update([
                'product_name'        => $request->product_name,
                'procate_id'        => $request->edit_category,
            ]);

            $data                = array();
            $data['message']     = 'Data has been updated.';
            $data['product_name'] = $product->product_name;
            $data['procate_name'] = $product->product_category->procate_name;
            $data['id'] = $product->id;

            // dd($data);

            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        }
    }

    public function delete(Request $request) {
        $category = Product::findOrFail($request->id);
        $category->delete();
        $data['message'] = 'Product deleted successfully';
        $data['id']      = $request->id;

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

}
