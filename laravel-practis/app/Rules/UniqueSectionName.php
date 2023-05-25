<?php

namespace App\Rules;

use App\Models\Company;
use App\Models\Section;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueSectionName implements ValidationRule
{
    private ?Section $section;
    private ?Company $company;

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function __construct(Section $section = null, Company $company = null)
    {
        $this->section = $section;
        $this->company = $company;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->section) {
            // $this->section->getKey() => sectionのid
            // $value = 部署名
            // sectionsテーブルから、部署名と会社IDが同じもののレコードが存在するか検索
            $sectionExists = Section::query()
                ->when($this->section, function ($query) {
                    $query->whereKeyNot($this->section->getKey());
                })
                ->where([
                    ['name', $value],
                    ['company_id', $this->section->company_id],
                ])
                ->exists();
        } else {
            $sectionExists = Section::query()
                ->where([
                    ['name', $value],
                    ['company_id', $this->company->getKey()],
                ])
                ->exists();
        }
        if ($sectionExists) {
            $fail('部署名は既に存在しています。');
        }
    }
}
