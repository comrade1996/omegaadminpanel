<?php

namespace App\Http\Controllers\API;

use App\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    public function index()
    {
        return Unit::latest()->paginate(10);
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

            ]);

        return Unit::create([
            'name' => $request['name'],
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Unit $Unit
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Unit $unit)
    {
        $this->validate($request,
            [
                'name' => 'required|string|max:191'
            ]);

        $unit->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Unit $Unit
     * @return array
     * @throws \Exception
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return['message' => 'Unit Deleted'];
    }
    // public function search()
    // {
    //     if ($search = \Request::get('q'))
    //     {
    //         $units= Unit::where(function ($query) use($search)
    //         {
    //             $query->where('name','LIKE',"%$search%")
    //         })->paginate(10);
    //         return $units;
    //     }

    //     return $units=Unit::latest()->paginate(10);
    // }
}
