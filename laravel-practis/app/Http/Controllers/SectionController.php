<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
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
        $company = Company::findOrFail($company_id);

        $company->sections()->create([
           'company_id' => $company->id,
           'name' => $request->name
        ]);

        return redirect()
            ->route('companies.show', compact('company'))
            ->with('status', 'Section Created!');
    }

    public function show(Company $company, Section $section): View {
        $unjoin_users = User::where('company_id', $company->id)
            ->whereDoesntHave('sections', function ($query) use ($section) {
                $query->where('section_id', $section->id);
            })
            ->get();
        $company->load(['users' => function ($query) use ($section) {
            $query->whereDoesntHave('sections', function ($query) use ($section) {
                $query->where('section_id', $section->id);
            });
        }]);

        return view('companies.sections.show', compact('company', 'section', 'unjoin_users'));
    }

    public function edit(Company $company, Section $section): View {

        return view('companies.sections.edit', compact('company', 'section'));
    }

    public function update(UpdateSectionRequest $request, Company $company, Section $section): RedirectResponse
    {
        $section->fill($request->validated())
            ->save();
        return redirect()->route('companies.show', compact('company'));

    }

    public function destroy(Company $company, Section $section): RedirectResponse
    {
        foreach ($section->users as $user)
        {
            $section->users()->detach($user->id);
        }

        $section->delete();

        return redirect()->route('companies.show', ['company' => $company]);
    }
}
