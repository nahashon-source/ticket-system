<?php

namespace App\Validation;

use Illuminate\Validation\Validator;

class CustomValidator extends Validator
{
    protected $stopOnFirstFailure = false;

    public function setStopOnFirstFailure($value)
    {
        $this->stopOnFirstFailure = $value;
    }

    public function getRulesWithoutPlaceholders()
    {
        return $this->rules;
    }

    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }
}
