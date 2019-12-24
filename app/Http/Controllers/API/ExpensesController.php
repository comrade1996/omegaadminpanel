<?php

namespace App\Http\Controllers\API;

use App\Expenses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Expenses::latest()->paginate(10);
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
                'amount' => 'required|numeric',
                'category' => 'required|numeric',

            ]);

        return Expenses::create([
            'expensescategory_id' => $request['category'],
            'amount' => $request['amount'],

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function show(Expenses $expenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function edit(Expenses $expenses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Expenses $expenses
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Expenses $expenses)
    {

        $this->validate($request,
            [
                'amount' => 'required|numeric',
                'category' => 'required|numeric',

            ]);

        $expenses->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expenses $expenses
     * @return array
     * @throws \Exception
     */
    public function destroy($id)
    {
        $expenses = Expenses::findOrFail($id);
        $expenses->delete();
        return['message' => 'Expenses Deleted'];

    }
    public function search()
    {
        if ($search = \Request::get('q'))
        {
            $expenses= Expenses::where(function ($query) use($search)
            {
                $query->where('amount','LIKE',"%$search%")
                    ->orWhere('name','LIKE',"%$search%");
            })->paginate(10);
            return $expenses;
        }

        return $expenses=Expenses::latest()->paginate(10);
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
            $expenses = Expenses::whereBetween('created_at',[$startdate, $enddate])->get();
            return $expenses;
    }
}
