<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Basic Configuration
    |--------------------------------------------------------------------------
    |
    | Core settings for the API documentation
    |
    */
    'name' => env('APP_NAME', 'Laravel API'),
    'description' => env('API_DESCRIPTION', 'Comprehensive API documentation for authentication, user management, and geographic data management.'),
    'base_url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Route Filtering Configuration
    |--------------------------------------------------------------------------
    |
    | Define which routes should be included/excluded from documentation
    |
    */
    'routes' => [
        // Base prefix for API routes (e.g. 'api' for routes like 'api/users')
        'prefix' => 'api',

        // Routes to explicitly include
        'include' => [
            // URI patterns to include (supports wildcards)
            'patterns' => [
                'api/*',
                'api/auth/*',
                'api/internal/*',
            ],

            // Only routes with these middleware
            'middleware' => ['api'],

            // Only routes from these controllers
            'controllers' => [
                'App\Http\Controllers\Api\Internal\Auth\AuthController',
                'App\Http\Controllers\Api\Internal\Auth\RegisterController',
                'App\Http\Controllers\Api\Internal\General\AboutUsController',
                'App\Http\Controllers\Api\Internal\General\ContactMeController',
                'App\Http\Controllers\Api\Internal\Geo\GeoController',
                'App\Http\Controllers\Api\Internal\Management\MenuController',
                'App\Http\Controllers\Api\Internal\Management\RoleController',
                'App\Http\Controllers\Api\Internal\Management\UserController',
                'App\Http\Controllers\Api\Internal\User\ProfileController',
                'App\Http\Controllers\Api\Internal\User\UserController',
            ],
        ],

        // Routes to explicitly exclude
        'exclude' => [
            // URI patterns to exclude (supports wildcards)
            'patterns' => [
                '_boost/*',
                '_ignition/*',
                'sanctum/*',
            ],

            // Exclude routes with these middleware
            'middleware' => ['web'],

            // Exclude routes from these controllers
            'controllers' => [
                'Spatie\LaravelIgnition\Http\Controllers\ExecuteSolutionController',
                'Spatie\LaravelIgnition\Http\Controllers\HealthCheckController',
                'Laravel\Sanctum\Http\Controllers\CsrfCookieController',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Documentation Structure
    |--------------------------------------------------------------------------
    |
    | How the documentation should be organized in Postman
    |
    */
    'structure' => [
        'folders' => [
            // Grouping strategy: 'prefix', 'nested_path', 'controller'
            'strategy' => 'nested_path',
            'max_depth' => 4, //  when strategy is nested_path

            // Custom name mapping for folders
            'mapping' => [
                'api' => 'Investment Learning API',
                'auth' => 'Authentication & Authorization',
                'internal' => 'Internal APIs',
                'general' => 'General Content Management',
                'management' => 'User & Role Management',
                'geo' => 'Geographic Data',
                'user' => 'User Profile Management',
                'about-us' => 'About Us Management',
                'contact-me' => 'Contact Messages',
                'roles' => 'Role Management',
                'menus' => 'Menu Management',
                'users' => 'User Management',
                'profile' => 'User Profile',
            ],
        ],

        /**
         * Postman request naming format.
         * Placeholders: {method}, {uri}, {controller}, {action}
         * Example: '[POST] /users' or 'UserController@store'
         */
        'naming_format' => '{action} - [{method}] {uri}',

        /**
         * Body generation rules
         * Determines the default format for request bodies in Postman documentation.
         * Supported: 'raw', 'formdata'
         */
        'requests' => [
            'default_body_type' => 'raw',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Group Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how route groups should be handled in Postman collection
    | This allows dynamic URL generation based on route groups
    |
    */
    'groups' => [
        // Enable group-based URL generation
        'enabled' => true,

        // Map route groups to environment variables
        'mapping' => [
            'auth' => '{{base_url}}/{{auth_prefix}}',           // api/auth
            'api' => '{{base_url}}/{{api_prefix}}',             // api
            'api-internal' => '{{base_url}}/{{api_internal}}',  // api/internal
            'api-external' => '{{base_url}}/{{api_external}}',  // api/external
        ],

        // Default prefixes for environment variables
        'defaults' => [
            'auth_prefix' => 'api/auth',
            'api_prefix' => 'api',
            'api_internal' => 'api/internal',
            'api_external' => 'api/external',
        ],

        // Auto-detect route group from middleware or prefix
        'auto_detect' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for API authentication documentation and examples
    |
    | Determines how authentication is handled in the generated documentation,
    | including auth type detection, protected route identification, and
    | example values for documentation purposes.
    |
    */
    'auth' => [
        // Enable authentication documentation
        'enabled' => true,

        // Supported: 'bearer', 'basic', 'api_key'
        'type' => 'bearer',

        // Where to send the auth: 'header' or 'query'
        'location' => 'header',

        // Default values (use env vars for real values)
        'default' => [
            'token' => '{{access_token}}',              // Dynamic token from login response
            'username' => 'user@example.com',           // For basic auth
            'password' => 'SecurePassword123!',         // For basic auth
            'key_name' => 'Authorization',              // For bearer token
            'key_value' => 'Bearer {{access_token}}',   // Bearer token format
        ],

        // Middleware that indicate protected routes
        'protected_middleware' => ['auth:sanctum', 'sanctum'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Headers
    |--------------------------------------------------------------------------
    |
    | Headers to include with every request
    |
    */
    'headers' => [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'X-Requested-With' => 'XMLHttpRequest',
    ],

    /*
    |--------------------------------------------------------------------------
    | Output Configuration
    |--------------------------------------------------------------------------
    |
    | Where and how to save the generated documentation
    |
    */
    'output' => [
        'driver' => env('POSTMAN_STORAGE_DISK', 'local'),

        // Storage path for generated files
        'path' => env('POSTMAN_STORAGE_DIR', storage_path('postman')),

        // File naming pattern (date will be appended)
        'filename' => env('POSTMAN_STORAGE_FILE', 'postman_api_collection.json'),
    ],
];
