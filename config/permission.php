<?php

return [

    'models' => [

        /*
         * Specify the Eloquent model to be used for retrieving permissions.
         * By default, it uses Spatie's Permission model.
         */
        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * Specify the Eloquent model to be used for retrieving roles.
         * By default, it uses Spatie's Role model.
         */
        'role' => Spatie\Permission\Models\Role::class,
    ],

    'table_names' => [

        /*
         * Table name to store roles.
         */
        'roles' => 'roles',

        /*
         * Table name to store permissions.
         */
        'permissions' => 'permissions',

        /*
         * Table name to store model permissions.
         */
        'model_has_permissions' => 'model_has_permissions',

        /*
         * Table name to store model roles.
         */
        'model_has_roles' => 'model_has_roles',

        /*
         * Table name to store role permissions.
         */
        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        /*
         * Specify the pivot key for roles. Default is `role_id`.
         */
        'role_pivot_key' => null, // default: 'role_id'

        /*
         * Specify the pivot key for permissions. Default is `permission_id`.
         */
        'permission_pivot_key' => null, // default: 'permission_id'

        /*
         * Specify the morph key for models. Default is `model_id`.
         * Useful if you are using UUIDs or custom keys.
         */
        'model_morph_key' => 'model_id',

        /*
         * Specify the foreign key for teams if using the teams feature.
         */
        'team_foreign_key' => 'team_id',
    ],

    /*
     * Specify the default guards for roles and permissions.
     */
    'guards' => ['sanctum'], // Default is ['web'], use ['sanctum'] for API-based authentication

    /*
     * Register a custom method to check permissions on Laravel's Gate.
     */
    'register_permission_check_method' => true,

    /*
     * Enable the Octane reset listener to refresh permissions when running Octane.
     */
    'register_octane_reset_listener' => false,

    /*
     * Teams feature: If enabled, the package will use the `team_foreign_key`.
     * Ensure the `team_foreign_key` column exists in the database tables.
     */
    'teams' => false,

    /*
     * Enable Passport client credentials grant for permissions.
     */
    'use_passport_client_credentials' => false,

    /*
     * Display required permission names in exception messages.
     * Useful for debugging but may expose sensitive information.
     */
    'display_permission_in_exception' => false,

    /*
     * Display required role names in exception messages.
     * Useful for debugging but may expose sensitive information.
     */
    'display_role_in_exception' => false,

    /*
     * Enable wildcard support for permissions.
     * See the documentation for supported syntax.
     */
    'enable_wildcard_permission' => false,

    /*
     * Specify the class to interpret wildcard permissions.
     */
    // 'permission.wildcard_permission' => Spatie\Permission\WildcardPermission::class,

    'cache' => [

        /*
         * Cache expiration time for permissions. Default is 24 hours.
         */
        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * Cache key for storing all permissions.
         */
        'key' => 'spatie.permission.cache',

        /*
         * Specify a cache store driver, or use the default one.
         */
        'store' => 'default',
    ],
];
