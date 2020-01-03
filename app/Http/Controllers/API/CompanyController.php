<?php

namespace App\Http\Controllers\API;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index()
    {
        return Company::latest()->paginate(10);
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

        return Company::create([
            'name' => $request['name'],
            'description' => $request['description'],


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
     * @param Company $Company
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Company $company)
    {
        $this->validate($request,
            [
                'name' => 'required|string|max:191',
                'description' => 'required|string',


            ]);

        $company->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param company $company
     * @return array
     * @throws \Exception
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return['message' => 'company Deleted'];
    }


    public function search()
    {
        if ($search = \Request::get('q'))
        {
            $companys= Company::where(function ($query) use($search)
            {
                $query->where('name','LIKE',"%$search%")
                    ->orWhere('description','LIKE',"%$search%");
            })->paginate(10);
            return $companys;
        }

        return $companys=Company::latest()->paginate(10);
    }
}
