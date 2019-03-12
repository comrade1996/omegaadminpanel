<?php

namespace App\Http\Controllers\API;

use App\SaleDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class SalesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SaleDetail::latest()->paginate(1000000);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $sells = json_decode($request['sells']);
        $sellid =$request['sale_id'];
        $arrLength=count($sells);
        echo gettype($sells);
        print_r($sells);

        echo count($sells);
        for($i=0;$i<count($sells);$i++) {
            $tempSell =new SaleDetail();
            $tempSell->sale_id = $sellid;
            $tempSell->quantity = $sells[$i]->quantity;
            $tempSell->product_id = $sells[$i]->id;
            $tempSell->price = $sells[$i]->sellingprice;
            $tempSell->save();
        }

        return['message' => 'SalesDetails stored'];

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function search()
    {
        if ($search = \Request::get('q'))
        {
            $salesDetails= SaleDetail::where(function ($query) use($search)
            {
                $query->where('sale_id','LIKE',"%$search%")
                ->orWhere('price','LIKE',"%$search%");
            })->paginate(100);
            return $salesDetails;
        }
        else {
            return $salesDetails = SaleDetail::latest()->paginate(100000);
        }
    }

    public function persist($sells,$id)
    {
        $sells = $sells;
        $sellid =$id;
        echo $sells[1];
        echo Request::get('q');
        foreach ($sells as $sell) {
            if($sell->quantity ==0){
            $tempSell =new SaleDetail();
            $tempSell->id = $sellid;
            $tempSell->quantity = $sell->quantity;
            $tempSell->product_id = $sell->id;
            $tempSell->price = $sell->sellingprice;
            $tempSell->save();
            }
            echo $sell->quantity;
        }

        return['message' => 'SalesDetails updated'];
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
            $salesDetails = SaleDetail::whereBetween('created_at',[$startdate, $enddate])->get();
            return $salesDetails;
    }
}
