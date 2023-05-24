<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueSectionName implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function __construct($company_id)
    {
        $this->company_id = $company_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $existing_section = DB::table('sections')
            ->where('company_id', $this->company_id)
            ->where('name', $value)
            ->exists();
        if ($existing_section)
        {
            $fail('部署名は既に存在しています。');
        }
    }
}
