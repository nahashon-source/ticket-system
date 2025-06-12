<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class TestController extends Controller
{
    public function testValidator(ValidationFactory $factory)
    {
        $validator = $factory->make(
            ['name' => ''],
            ['name' => 'required']
        );

        // Commented out since not universally available
        // $validator->setStopOnFirstFailure(true);

        if ($validator->fails()) {
            dd($validator->errors());
        } else {
            dd('Validation passed');
        }
    }
}
