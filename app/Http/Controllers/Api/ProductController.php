<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('can:manage-products');
    }

    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=> ['required'],
            'stock'=> ['required'],
            'description' => ['required'],
            'price_min' => ['required'],
            'price_max' => ['required'],
        ]);

        return Product::create($request->all());
    }

    public function show($id)
    {
        return Product::find($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=> ['required'],
            'stock' => ['required'],        
            'description' => ['required'],
            'price_min' => ['required'],
            'price_max' => ['required'],
        ]);

        $product= Product::find($id);

        $product->update([
            "name" => $request['name'],
            "stock" => $request['stock'],
            "description" => $request['description'],
            "price_min" => $request['price_min'],
            "price_max" => $request['price_max']
        ]);

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product= Product::find($id);
        $state= $product->state;

        if($this->verifyProductHasAssignedElements($product))
        {
            return response()->json([
                'name'=>"The product $product->name has assigned elements",
                'code'=>'400',
            ]);
        }
        $product->state=!$state;
        $product->save();
        return $product;
    }

    public function verifyProductHasAssignedElements(Product $product)
    {
        if($product->stock>0)
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }
}
