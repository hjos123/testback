<?php
namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests\ProductStoreRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
      //$date = date("Y-m-d H:i:s");
      //$id = $request->user()->id;
    	//$product = Product::where("user_id","=",$id)->where('date_available','>', $date )->get();
      $products = Product::all();
      return response()->json( $products ,  200);
      //return response()->json([$request->user()], 200);
    }

    public function save(ProductStoreRequest $request)
    {
      $input = $request->all();
      $input['user_id'] = $request->user()->id;
    	$product = Product::create($input);
    	return response()->json(['product' => $product], 200);
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

          $product->path = asset('assets/products')."/".$picture;
          $product->save();

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
