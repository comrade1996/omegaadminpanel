<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\ExpensesCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpensesCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ExpensesCategory::latest()->paginate(10);
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
                'name' => 'required|string|max:191',
                'description' => 'required|string',


            ]);

        return ExpensesCategory::create([
            'name' => $request['name'],
            'description' => $request['description'],

        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpensesCategory $expensesCategory
     * @return void
     */
    public function show(ExpensesCategory $expensesCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExpensesCategory $expensesCategory
     * @return void
     */
    public function edit(ExpensesCategory $expensesCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ExpensesCategory $expensesCategory
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request,$id)
    {
        $expensesCategory = ExpensesCategory::findOrFail($id);
        $this->validate($request,
            [
                'name' => 'required|string|max:191',
                'description' => 'required|string'

            ]);
        $test = $request->all();

        $expensesCategory->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpensesCategory $expensesCategory
     * @return array
     * @throws \Exception
     */
    public function destroy($id)
    {
        $expensesCategory = ExpensesCategory::findOrFail($id);

        $expensesCategory->delete();
        return['message' => 'Expenses Category Deleted'];
    }

    public function search()
    {
        if ($search = \Request::get('q'))
        {
            $expensescategories= ExpensesCategory::where(function ($query) use($search)
            {
                $query->where('name','LIKE',"%$search%")
                    ->orWhere('description','LIKE',"%$search%");
            })->paginate(10);
            return $expensescategories;
        }

        return $expensescategories=ExpensesCategory::latest()->paginate(10);
    }
}
