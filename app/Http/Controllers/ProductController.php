<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function create_ordered(Request $request){

        $new_Order_qty = $request->ordered_quantity;

            $product = Product::where('model_number', $request->model_number)->get();

            if ($request->current_quantity != 0 ) {

                $new_Order_qty = Product::where('model_number', $request->model_number)->sum('ordered_quantity') - $request->current_quantity;

                if ($request->current_quantity != '') {
                
                    $request->current_quantity = 0;
                
                }else if ($request->ordered_quantity != '') {
                
                    $request->ordered_quantity = 0;
                
                }
                
                
                DB::table('products')->insert([
                    'model_number' => $request->model_number,
                    'category_product' => $request->category_product,
                    'ordered_quantity' => $new_Order_qty,
                    'current_quantity' => $request->current_quantity,
                    'price' => $request->price,
                    'no_invoice' => $request->no_invoice
                ]);
                
                foreach ($product as $row) {
                    
                    DB::table('products')->where('id', $row->id)->delete();
                }
            }else {
                
                DB::table('products')->insert([
                    'model_number' => $request->model_number,
                    'category_product' => $request->category_product,
                    'ordered_quantity' => $new_Order_qty,
                    'current_quantity' => $request->current_quantity,
                    'price' => $request->price,
                    'no_invoice' => $request->no_invoice
                ]);
            }

        return response()->json([
            'message' => 'Add Product'
        ]);

    }

    public function update(Request $request, $model_number){

        DB::table('products')->where('model_number', $model_number)
        ->update([
            'model_number' => $request->model_number,
            'category_product' => $request->category_product,
            'ordered_quantity' => $request->ordered_quantity,
            'current_quantity' => $request->current_quantity,
            'price' => $request->price,
            'no_invoice' => $request->no_invoice
        ]);

        return response()->json([
            'message' => 'update Product'
        ]);
    }

    public function delete($model_number){
        
        DB::table('products')->where('model_number', $model_number)->delete();

        return response()->json([
            'message' => 'Delete Product'
        ]);
    }

    public function inventory_list(){
        $product = DB::table('products')->groupBy('model_number')->selectRaw('model_number, category_product, ordered_quantity, current_quantity, avg(price) as avg_price')->get();
        // $avg = Product::avg('price');
            
            return response()->json([
                'data' => $product,
            ]);
    }

    public function order_list(){

        $product = DB::table('products')->select('model_number', 'ordered_quantity', 'no_invoice', 'price')->where('model_number', '!=' ,'')->whereNotNull('ordered_quantity')->get();
            
            return response()->json([
                'data' => $product
            ]);
    }
}
