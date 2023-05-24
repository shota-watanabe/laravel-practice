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
     */
    public function index(User $user, Company $company): bool
    {
        return $user->company->id === $company->id;
    }
}
