<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserSectionRequest;
use App\Models\Company;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSectionController extends Controller
{
    public function store(StoreUserSectionRequest $request, Company $company, Section $section): RedirectResponse
    {
        $section->users()->attach($request->user_id);

        $company->load(['users' => function ($query) use ($section) {
            $query->whereDoesntHave('sections', function ($query) use ($section) {
                $query->where('section_id', $section->id);
            });
        }]);

        return redirect()->route('companies.sections.show', compact('company', 'section'));

    }
}
