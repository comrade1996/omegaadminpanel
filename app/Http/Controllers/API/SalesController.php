<?php

namespace App\Http\Controllers\API;

use App\Sales;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SaleDetail;
use Illuminate\Support\Facades\Auth;
use phpseclib\Math\BigInteger;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Sales::latest()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
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
                'subtotal' => 'required|numeric',
                'discount' => 'numeric',
                'grandtotal' => 'required|numeric'
            ]);

            $digits = 5;
            $saleid = rand(pow(10, $digits-1), pow(10, $digits)-1);
       // = mt_rand(100000, 999999);
        if( $request['subtotal']>0){
        Sales::create([
            'id'=> $saleid,
            'subtotal' => $request['subtotal'],
            'discount' => $request['discount'],
            'grandtotal' => $request['grandtotal'],


        ]);
        return $saleid;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sales  $Sales
     * @return \Illuminate\Http\Response
     */
    public function show(Sales $Sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sales  $Sales
     * @return \Illuminate\Http\Response
     */
    public function edit(Sales $Sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Sales $Sales
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $Sales = Sales::findOrFail($id);
        $this->validate($request,
            [
                'subtotal' => 'required|numeric',
                'discount' => 'numeric',
                'grandtotal' => 'required|numeric'
            ]);

        $Sales->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sales $Sales
     * @return array
     * @throws \Exception
     */
    public function destroy($id)
    {
        $Sales = Sales::findOrFail($id);
        $salesQuery = SaleDetail::where('sale_id', '=',$id)->get();
        foreach ($salesQuery as $saleQuery) {
            // $tempProduct = new Product();
            $tempProduct = Product::findOrFail($saleQuery->product_id);
            // dd($tempProduct);
            $tempProduct->quantity = $tempProduct->quantity + $saleQuery->quantity;
            $tempProduct->save();
            // $affectedRows = SaleDetail::where('sale_id','=',$id)->delete();
            // var_dump($affectedRows);
            $saleQuery->delete();
            // var_dump($saleQuery);
        }
        $Sales->delete();
        return['message' => 'Sales Deleted'];

    }
    public function search()
    {
        if ($search = \Request::get('q'))
        {
            $sales= Sales::where(function ($query) use($search)
            {
                $query->where('subtotal','LIKE',"%$search%")
                    ->orWhere('discount','LIKE',"%$search%")
                ->orWhere('grandtotal','LIKE',"%$search%")
                ->orWhere('id','LIKE',"%$search%");
            })->paginate(10);
            return $sales;
        }

        return $sales=Sales::latest()->paginate(10);
    }

    public function dateFilter(Request $request)
    {
        $this->validate($request,
            [
                'startdate' => 'required|',
                'enddate' => 'required'
            ]);

        $startdate =$request['startdate'];
        $enddate =$request['enddate'];
            $sales = Sales::whereBetween('created_at',[$startdate, $enddate])->get();
            return $sales;
    }
}
