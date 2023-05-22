<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function create($id): View
    {
        $company = Company::findOrFail($id);

        return view('companies.sections.create', compact('company'));
    }

    public function store(StoreSectionRequest $request): RedirectResponse
    {
        dd($request->all());
    }
}
