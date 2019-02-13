<?php

namespace App\Http\Controllers\API;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return Product::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|string|max:191',
                'purchaseprice' => 'required|numeric',
                'sellingprice' => 'required|numeric',
                'category' => 'required|numeric',
                'quantity' => 'required|numeric',
                'edate' => 'required|date|after:today'
            ]);

        return Product::create([
            'name' => $request['name'],
            'purchaseprice' => $request['purchaseprice'],
            'sellingprice' => $request['sellingprice'],
            'category_id' => $request['category'],
            'quantity' => $request['quantity'],
            'edate' => $request['edate'],
            'company' => $request['company']
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Product $product
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request,
            [
                'name' => 'required|string|max:191',
                'purchaseprice' => 'required|numeric',
                'sellingprice' => 'required|numeric',
                'category' => 'required|numeric',
                'quantity' => 'required|numeric',
                'edate' => 'required|date|after:today'
            ]);

        $product->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return array
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return['message' => 'Product Deleted'];
    }
}
