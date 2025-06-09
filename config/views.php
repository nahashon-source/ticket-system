<?php

return [
    'paths' => [
        resource_path('views'), // This points to the resources/views folder
    ],
    'compiled' => realpath(storage_path('framework/views')), // This stores compiled views
];
