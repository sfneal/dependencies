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

        'python' => [
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
    'composer_json_path' => base_path('composer.json'),

    /*
    |--------------------------------------------------------------------------
    | GitHub account alias's
    |--------------------------------------------------------------------------
    |
    | Specify an array of Docker Hub accounts that don't match GitHub account
    | names.  Used to correct GitHub & Travis CI urls
    |
    | Supported: ['dockerUsername' => 'githubUsername]
    |
    */
    'github_alias' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Specify key prefixes & TTLs for caching `DependencyRepository` collections.
    |
    */
    'cache' => [
        'prefix' => 'dependencies:repository',
        'ttl' => 3600,
    ],
];
