<?php

namespace App\Rules;

use Closure;
use DB;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueCompositeKey implements ValidationRule
{
    protected string $table;
    protected array $columns;

    public function __construct(string $table, array $columns)
    {
        $this->table = $table;
        $this->columns = $columns;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = DB::table($this->table);

        foreach ($this->columns as $column) {
            $query->where($column, request()->input($column));
        }

        if ($query->exists()) {
            $attributes = implode(', ', $this->columns);
            $fail(__('validation.composite_key_exists', ['attribute' => $attributes]));
        }
    }
}
