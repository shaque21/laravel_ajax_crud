<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function index(){

        $categories = ProductCategory::get();
        return view('admin.product_category.index',compact('categories'));
    }


    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
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
            $category = ProductCategory::create([
                'procate_name' => $request->name,
                
            ]);
            

            $data = array();
            $data['message'] = "Data Added Successfully";
            $data['procate_name'] = $category->procate_name;
            $data['created_at'] = $category->created_at;
            $data['id'] = $category->id;

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        }


    }

    public function view(Request $request) {
        $data = ProductCategory::findOrFail($request->id);
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
        $data = ProductCategory::findOrFail($request->id);
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

    public function update(Request $request, ProductCategory $itemCategory) {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:50',
        ]);
        if ($validator->fails()) {
            $data          = array();
            $data['error'] = $validator->errors()->all();
            return response()->json([
                'success' => false,
                'data'    => $data,
            ]);
        } else {
            $category = ProductCategory::findOrFail($request->hidden_id);
            $category->update([
                'procate_name'        => $request->name,
            ]);

            $data                = array();
            $data['message']     = 'Data has been updated.';
            $data['procate_name'] = $category->procate_name;
            $data['created_at'] = $category->created_at;
            $data['id'] = $category->id;

            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        }
    }

    public function delete(Request $request) {
        $category = ProductCategory::findOrFail($request->id);
        $category->delete();
        $data['message'] = 'Category deleted successfully';
        $data['id']      = $request->id;

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
}
