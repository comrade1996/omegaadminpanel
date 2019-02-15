<?php

namespace App\Http\Controllers\API;

use App\Sales;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        return Sales::create([
            'subtotal' => $request['subtotal'],
            'discount' => $request['discount'],
            'grandtotal' => $request['grandtotal']
        ]);
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
        $Sales->delete();
        return['message' => 'Sales Deleted'];

    }
}
