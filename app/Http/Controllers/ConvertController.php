<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ConvertController extends Controller
{
    public function convert(Request $request){

        $codeModels = $request->code;

        $product = Product::all();

            $shortest = -1;

                foreach ($product as $row) {
                    
                    $convert = levenshtein($codeModels, $row->model_number);

                    if ($convert == 0) {

                        $closest = $row;

                        break;
                    }

                    if ($convert <= $shortest || $shortest < 0) {
                        
                        $closest  = $row;
                        $shortest = $convert;
                        
                    }
                }

            return response()->json([
                "data" => $closest,
            ]);
    }   
}
