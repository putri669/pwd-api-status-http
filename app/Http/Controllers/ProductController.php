<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
   
    public function index()
    {     
        $products = Product::all();
        return response()->json([ 
            'success' => true,
            'data' => $products     
        ], 200); 
    } 

   
    public function store(Request $request)
    { 
        try {
            $request->validate([ 
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'stock' => 'required|integer' 
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bad Request: Invalid input',
                'errors' => $e->errors()
            ], 400);
        }

        $product = Product::create($request->all());
        return response()->json([ 
            'success' => true,
            'data' => $product
        ], 201); 
    }

   
    public function show($id)
    {     
        $product = Product::find($id); 
        if (!$product) {
            return response()->json([
                'success' => false, 
                'message' => 'Product not found'
            ], 404); 
        }    

        return response()->json([  
            'success' => true, 
            'data' => $product     
        ], 200); 
    } 

    
    public function update(Request $request, $id)
    {     
        $product = Product::find($id);
        
        if (!$product) { 
            return response()->json([
                'success' => false, 
                'message' => 'Product not found'
            ], 404); 
        }    

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'stock' => 'required|integer'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bad Request: Invalid input',
                'errors' => $e->errors()
            ], 400); 
        }
        
        $product->update($request->all());
        return response()->json([
            'success' => true,
            'data' => $product
        ], 200);
    }   

    public function destroy($id)
    { 
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
                'success' => false, 
                'message' => 'Product not found'
            ], 404); 
        } 
        
        $product->delete();
        return response()->json([
            'success' => true, 
            'message' => 'Product deleted successfully'
        ], 204);
    } 

    
    public function unauthorizedExample()
    {
        return response()->json([
            'success' => false, 
            'message' => 'Unauthorized access'
        ], 401); 
    }

   
    public function forbiddenExample()
    {
        return response()->json([
            'success' => false, 
            'message' => 'Forbidden: You do not have access to this resource'
        ], 403); 
    }

    public function methodNotAllowedExample()
    {
        return response()->json([
            'success' => false, 
            'message' => 'Method Not Allowed'
        ], 405); 
    }

    public function acceptedExample()
    {
        return response()->json([
            'success' => true, 
            'message' => 'Request accepted, processing in progress'
        ], 202);
    }
}