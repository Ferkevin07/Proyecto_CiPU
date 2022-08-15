<?php

namespace App\Http\Controllers\Api\client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:client-manage-resources');
    }

    public function index()
    {
        $products=Product::all();
        return $products;
    }
    
    public function show($id)
    {
        $product=Product::find($id);
        return $product;
    }

}
