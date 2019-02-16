<?php

namespace App\Http\Controllers\API;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::latest()->paginate(10);
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
                'description' => 'required|string'

            ]);

        return Category::create([
            'name' => $request['name'],
            'description' => $request['description']
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
     * @param Category $category
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request,
            [
                'name' => 'required|string|max:191',
                'description' => 'required|string'
            ]);

        $category->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return array
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return['message' => 'Category Deleted'];
    }
    public function search()
    {
        if ($search = \Request::get('q'))
        {
            $categories= Category::where(function ($query) use($search)
            {
                $query->where('name','LIKE',"%$search%")
                    ->orWhere('description','LIKE',"%$search%");
            })->paginate(10);
            return $categories;
        }

        return $categories=Category::latest()->paginate(10);
    }
}
