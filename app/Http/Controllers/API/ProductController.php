<?php

namespace App\Http\Controllers\API;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return Product::latest()->paginate(100000);
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

    public function persist(Request $request)
    {
        $products[] = json_decode($request['products']);
        echo gettype($products);
        print_r($products);
        echo count($products);
        for($i=0;$i<count($products);$i++) {
            for ($j = 0; $j < count($products[$i]); $j++) {
                $tempProduct = new Product();
                $tempProduct = Product::findOrFail($products[$i][$j]->id);
                $tempProduct->quantity = $tempProduct->quantity - $products[$i][$j]->quantity;
                $tempProduct->save();
            }
        }
        return['message' => 'Product ss updated'];
    }
    public function search()
    {
        if ($search = \Request::get('q'))
        {
            $products= Product::where(function ($query) use($search)
            {
                $query->where('name','LIKE',"%$search%")
                    ->orWhere('purchaseprice','LIKE',"%$search%")
                    ->orWhere('sellingprice','LIKE',"%$search%")
                    ->orWhere('company','LIKE',"%$search%")
                    ->orWhere('quantity','LIKE',"%$search%");
            })->paginate(10);
            return $products;
        }

        return $products=Product::latest()->paginate(10);
    }
}
