<?php
namespace App\Http\Controllers;

use App\Product;
use Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $date = date("Y-m-d H:i:s");
        $id = $request->user()->id;
    	$product = Product::where("user_id","=",$id)->where('date_available','>', $date )->get();
        return response()->json( $product ,  200);
    }

    public function save(Request $request)
    {
    	$validator = Validator::make($request->all(), [ 
        'name' => 'required', 
        'description' => 'required',
        'date_available' => 'required',
        ]);
		
		if ($validator->fails()) 
        	return response()->json(['error'=>$validator->errors()], 202);

        $input = $request->all(); 
        $input['user_id'] = $request->user()->id; 
    	$product = Product::create($input);
    	return response()->json(['mensaje'=>"producto almacenado","idprod" => $product->id ],200);
    }
    
    public function uploadImage(Request $request)
    {
         if ($request->hasFile('image'))
        {   
            $file      =    $request->file('image');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = $request->id_prod."_".$request->id_img.".".$extension;
            $file->move(public_path('assets/products/'), $picture);
            
            if ($request->id_img == 0)
            {
				$product = Product::find($request->id_prod);
				$product->path = asset('assets/products')."/".$picture;
				$product->save();
			}
    
            return response()->json([ "message" => "imagen cargada con exito." ], 200);
        }
		return response()->json([ "message" => "error al subir"], 202);
	}
}
