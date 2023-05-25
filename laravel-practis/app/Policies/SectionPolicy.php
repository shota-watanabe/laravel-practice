<?php

namespace App\Policies;

use App\Models\Company;
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

    /**
     * 指定した部署の会社をユーザーが閲覧可能かを判定
     * 部署一覧は会社の詳細画面で閲覧可能
     */
    public function viewAny(User $user, Company $company): bool
    {
        return $user->company->id === $company->id;
    }

    public function view(User $user, Company $company, Section $section): bool
    {
        return $user->company->id === $company->id && $company->id && $section->company->id;
    }

    public function create(User $user, Company $company): bool
    {
        return $user->company->id === $company->id;
    }

    public function update(User $user, Company $company, Section $section): bool
    {
        return $user->company->id === $company->id && $company->id && $section->company->id;
    }

    public function delete(User $user, Company $company, Section $section): bool
    {
        return $user->company->id === $company->id && $company->id && $section->company->id;
    }
}
