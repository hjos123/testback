<?php
namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductImageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
      $date = date("Y-m-d H:i:s");
      $id = Auth::user()->id;
    	$product = Product::where("user_id","=",$id)->where('date_available','>', $date )->get();
      return response()->json($product);
    }

    public function save(ProductStoreRequest $request)
    {
      $input = $request->all();
      $input['user_id'] = $request->user()->id;
    	$product = Product::create($input);
    	return response()->json(['product' => $product]);
    }

    public function uploadImage(ProductImageRequest $request)
    {
      $product = Product::find($request->product_id);
      if ( !empty($product->id) )
      {
        $aux = 1;
        $files = $request->file('image');
        foreach ($files as $file) {
          $extension = $file->getClientOriginalExtension();
          $file->move(public_path('img/products/'.$product->id), $aux.'.'.$extension);
          if ($aux == 1){
            $product->path = asset('img/products/'.$product->id)."/".$aux.'.'.$extension;
            $product->save();
          }
          $aux++;
        }
        return response()->json(['message' => "Se almacen las fotografias con exito"]);
      }else
        return response()->json(['message' => "Error no se encontro el producto"], 202);
	  }
}
