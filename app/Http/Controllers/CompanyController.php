<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests\storeCompanyRequest;
use App\Http\Requests\updateCompanyRequest;
use Intervention\Image\ImageManagerStatic as Image;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::latest()->paginate(10);
  
        return view('company.index',compact('companies'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeCompanyRequest $request)
    {

        $input = $request->all('name', 'email', 'website');

        //Storage::disk('public')->put('logo', $request->logo);

        if($request->hasFile('logo')) {

            $image = $request->file('logo');
            $filename = $image->getClientOriginalName();

            $filepath = public_path('storage/logo/' .$filename);

            $file_name = pathinfo($filename, PATHINFO_FILENAME);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);

            $i = 0;  

            while(File::exists($filepath)) {
                $i++;
                $temp_filename = $file_name . $i . '.' . $extension;
                $filepath = public_path('storage/logo/' . $temp_filename);
                $filename = $temp_filename;
            }

            $image_resize = Image::make($image->getRealPath());              
            $image_resize->resize(100, 100);
            $image_resize->save(public_path('storage/logo/' .$filename));

            $input['logo'] = $filename;
        }

        Company::create($input);
   
        return redirect()->route('company.index')->with('success','Successfully created company.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('company.show',compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('company.edit',compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(updateCompanyRequest $request, Company $company)
    {

        $input = $request->all('name', 'email', 'website');

        //Storage::disk('public')->put('logo', $request->logo);

        if($request->hasFile('logo')) {

            $image = $request->file('logo');
            $filename = $image->getClientOriginalName();

            $filepath = public_path('storage/logo/' .$filename);

            $file_name = pathinfo($filename, PATHINFO_FILENAME);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
    
            $i = 0;  
            while(File::exists($filepath)) {
                $i++;
                $temp_filename = $file_name . $i . '.' . $extension;
                $filepath = public_path('storage/logo/' . $temp_filename);
                $filename = $temp_filename;
            }

            $image_resize = Image::make($image->getRealPath());              
            $image_resize->resize(100, 100);
            $image_resize->save(public_path('storage/logo/' .$filename));

            $input['logo'] = $filename;

            $image_path = public_path('storage/logo/' . $company->logo);

            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        else {
           $input['logo'] = $company->logo;
        }
 
        $company->update($input);
        
        return redirect()->route('company.index')
                        ->with('success','Successfully updated company');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
  
        return redirect()->route('company.index')->with('success','Successfully deleted company');
    }
}
