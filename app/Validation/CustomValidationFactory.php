<?php

namespace App\Validation;

use Illuminate\Validation\Factory;
use App\Validation\CustomValidator;


class CustomValidationFactory extends Factory
{
    public function make(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        return new CustomValidator($this->translator, $data, $rules, $messages, $customAttributes);
    }
}
