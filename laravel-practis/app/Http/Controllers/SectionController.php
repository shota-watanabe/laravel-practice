<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Models\Company;
use App\Models\Section;
use App\Models\User;
use App\Models\UserSection;
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

    public function store(StoreSectionRequest $request, $company_id): RedirectResponse
    {
        $section = New Section();
        $company = Company::findOrFail($company_id);
        // $company->sections->fill($request->validated())->save();

        // $request->validated();
        $section = $section->create([
           'company_id' => $company->id,
           'name' => $request->name
        ]);

        $user_section = New UserSection();
        $user_section->create([
            'user_id' => Auth::id(),
            'section_id' => $section->id
        ]);

        return redirect()
            ->route('companies.index')
            ->with('status', 'Section Created!');
    }

    public function edit($company_id, $section_id) {
        $company = Company::findOrFail($company_id);
        $section = Section::findOrFail($section_id);

        return view('companies.sections.edit', compact('company', 'section'));
    }
}
