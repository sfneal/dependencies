<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Composer dependencies
    |--------------------------------------------------------------------------
    |
    | Create an array of composer dependencies you would like to be able to
    | monitor from within your application.  If left null, composer requirements
    | will be used by default
    |
    | Supported: [
    |   'vendor1/package1',
    |   'vendor2/package2',
    | ];
    |
    */
    'dependencies' => [
        'composer' => [
            //
        ],

        'docker' => [
            //
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | composer.json path
    |--------------------------------------------------------------------------
    |
    | Specify the path to the composer.json file that contains your
    | application's dependencies.  Default is the composer.json in the project
    | root.
    |
    | Supported: path to composer.json file
    |
    */
    'composer_json_path' => base_path('composer.json')
];
