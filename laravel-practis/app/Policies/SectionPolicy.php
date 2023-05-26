<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\Section;
use App\Models\User;

class SectionPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Section $section, Company $company): bool
    {
        return $user->company->id === $company->id && $company->id && $section->company->id;
    }

    public function create(User $user, Company $company): bool
    {
        return $user->company->id === $company->id;
    }

    public function update(User $user, Section $section, Company $company): bool
    {
        return $user->company->id === $company->id && $company->id && $section->company->id;
    }

    public function delete(User $user, Section $section, Company $company): bool
    {
        return $user->company->id === $company->id && $company->id && $section->company->id;
    }
}
