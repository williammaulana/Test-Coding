<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConvertController extends Controller
{
    public function convert(Request $request){

        $codeModels = $request->code;
            // $convert = substr($codeModels, 3);
            $convert = trim($codeModels, '00 ');

            return response()->json([
                $data = $convert,
            ]);
    }   
}
