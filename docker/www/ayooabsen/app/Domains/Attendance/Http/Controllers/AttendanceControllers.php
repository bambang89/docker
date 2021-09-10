<?php

namespace App\Domains\Company\Http\Controllers;

use App\Domains\Company\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class CompanyController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.company.index');
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return view('backend.company.create', [
            'title' => 'Create Company'
        ]);
    }

    /**
     * @param  Request  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $request->validate($this->rules);

        Company::create([
            'name'          => $request->input('name'),
            'subdomain'     => $request->input('subdomain'),
            'address'       => $request->input('address'),
            'email'         => $request->input('email'),
            'phone'         => $request->input('phone'),
            'country_code'  => $request->input('country_code'),
            'zip_code'      => $request->input('zip_code'),
            'business_name' => $request->input('business_name'),
            'status'        => $request->input('status'),
            'registered'    => $request->input('registered'),
            'expired'       => $request->input('expired'),
            'quota'         => $request->input('quota'),
        ]);

        return redirect()->route('admin.company.index')->withFlashAlert(__('The Company was successfully created.'));
    }

    /**
    * @return \Illuminate\View\View
    */
    public function edit($id)
    {
        $company = Company::find($id);

        return view('backend.company.create', [
            'title' => 'Edit Company',
            'company' => $company
        ]);
    }

    /**
     * Update the specified company.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            array_merge(
                $this->rules,
                [
                    'name'          => 'required|min:3|unique:companies,id,'.$request->input('id'),
                    'subdomain'     => 'required|min:3|unique:companies,id,'.$request->input('id'),
                    'email'         => 'required|email|unique:companies,id,'.$request->input('id'),
                ]
            )
        );
        // $request->validate($this->rules);

        $company = Company::find($id);
        if ($company) {
            $company->name          = $request->input('name');
            $company->subdomain     = $request->input('subdomain');
            $company->address       = $request->input('address');
            $company->email         = $request->input('email');
            $company->phone         = $request->input('phone');
            $company->country_code  = $request->input('country_code');
            $company->zip_code      = $request->input('zip_code');
            $company->business_name = $request->input('business_name');
            $company->status        = $request->input('status');
            $company->registered    = $request->input('registered');
            $company->expired       = $request->input('expired');
            $company->quota         = $request->input('quota');
            $company->update();
        }

        return redirect()->route('admin.company.index')->withFlashSuccess(__('The Company was successfully updated.'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function branch()
    {
        return view('backend.company.branch');
    }

}
