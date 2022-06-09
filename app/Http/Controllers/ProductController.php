<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\http\models\Product;
use DB;

class ProductController extends Controller
{
    public function create_ordered(Request $request){

        $data_product = Product::all();
        $model_number = trim($request->model_number, '00 ');

        $product->model_number = $model_number;
        $product->category_product = $request->category_product;

        if ($request->ordered_quantity != '') {
            foreach ($data_product as $row) {
                $new_order_quantity = $row->ordered_quantity + $request->ordered_quantity;
            }

            $product->ordered_quantity = $new_order_quantity;
        }
        $product->price = $request->price;
        $product->no_invoice = $request->no_invoice;

        DB::table('products')->insert($product);

        return response()->json([
            'message' => 'Add Product'
        ]);

    }

    public function create_current_stock(Request $request){

        $data_product = Product::all();
        $model_number = trim($request->model_number, '00 ');

        $product->model_number = $model_number;
        $product->category_product = $request->category_product;

        if ($request->current_quantity != '') {
            foreach ($data_product as $row) {
                $new_order_quantity = $row->current_quantity + $request->current_quantity;
            }

            $product->current_quantity = $new_current_quantity;
            $product->ordered_quantity = $request->ordered_quantity - $new_current_quantity;
        }
        $product->price = $request->price;
        $product->no_invoice = $request->no_invoice;

        DB::table('products')->insert($product);

        return response()->json([
            'message' => 'Add Product stock Current'
        ]);
    }

    public function update(Request $request, $model_number){

        $product = Product::find($model_number);

        $product->model_number = $request->model_number;
        $product->category_product = $request->category_product;
        $product->ordered_quantity = $request->ordered_quantity;
        $product->current_quantity = $request->current_quantity;
        $product->price = $request->price;
        $product->no_invoice = $request->no_invoice;

        $product->save();

        return response()->json([
            'message' => 'update Product'
        ]);
    }

    public function delete($model_number){
        Product::destroy($model_number);
        return response()->json([
            'message' => 'Delete Product'
        ]);
    }

    public function inventory_list(){
        $product = Product::all();
        $avg = Product::avg('price');

        foreach ($product as $row) {
            
            $data[] = array(
                'Model' => $row->model_number,
                'Category' => $row->category_product,
                'Ordered_Qty' => $row->ordered_quantity,
                'Current_Qty' => $row->current_quantity,
                'avg' => $avg,
            );
            
            return response()->json([
                $data = $data
            ]);
        }
    }

    public function order_list(){
        $product = Product::all();

        foreach ($product as $row) {
            
            $data[] = array(
                'Model' => $row->model_number,
                'Ordered_Qty' => $row->ordered_quantity,
                'No_invoice' => $row->no_invoice,
                'Price' =>$row->price,
            );
            
            return response()->json([
                $data = $data
            ]);
        }
    }
}
