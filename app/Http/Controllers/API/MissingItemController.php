<?php

namespace App\Http\Controllers\API;


use App\MissingItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MissingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MissingItem::latest()->paginate(10);
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

        return MissingItem::create([
            'name' => $request['name'],
            'description' => $request['description'],

        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MissingItem $MissingItem
     * @return void
     */
    public function show(MissingItem $missingItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExpensesCategory $missingItem
     * @return void
     */
    public function edit(MissingItem $missingItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\MissingItem $missingItem
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request,$id)
    {
        $missingItem = MissingItem::findOrFail($id);
        $this->validate($request,
            [
                'name' => 'required|string|max:191',
                'description' => 'required|string'

            ]);
        $test = $request->all();

        $missingItem->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MissingItem $missingItem
     * @return array
     * @throws \Exception
     */
    public function destroy(MissingItem $missingItem)
    {
        $missingItem->delete();
        return['message' => 'Misssing Item Deleted'];
    }

    public function search()
    {
        if ($search = \Request::get('q'))
        {
            $missingItems= MissingItem::where(function ($query) use($search)
            {
                $query->where('name','LIKE',"%$search%")
                    ->orWhere('description','LIKE',"%$search%");
            })->paginate(10);
            return $missingItems;
        }

        return $missingItems=MissingItem::latest()->paginate(10);
    }
}
