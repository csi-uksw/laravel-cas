<?php

return [
    /*
    |--------------------------------------------------------------------------
    | phpCAS Debug
    |--------------------------------------------------------------------------
    |
    | Example : '/var/log/phpCas.log'
    | or true for default location (/tmp/phpCAS.log)
    |
    */

    'cas_debug' => env('CAS_DEBUG', false),
    /*
    |--------------------------------------------------------------------------
    | phpCAS Hostname
    |--------------------------------------------------------------------------
    |
    | Example: 'login.uksw.edu.pl'
    |
    */

    'cas_hostname' => env('CAS_HOSTNAME', ''),
    /*
    |--------------------------------------------------------------------------
    | CAS Port
    |--------------------------------------------------------------------------
    |
    | Usually 443 is default
    |
    */

    'cas_port' => env('CAS_PORT', 443),
    /*
    |--------------------------------------------------------------------------
    | CAS URI
    |--------------------------------------------------------------------------
    |
    | Usually '/cas' is default
    |
    */

    'cas_uri' => env('CAS_URI', '/cas'),
    /*
    |--------------------------------------------------------------------------
    | CAS login URI
    |--------------------------------------------------------------------------
    |
    | Empty is fine
    |
    */
    'cas_login_uri' => env('CAS_LOGIN_URI', ''),
    /*
    |--------------------------------------------------------------------------
    | CAS logout URI
    |--------------------------------------------------------------------------
    |
    | Example: 'https://login.uksw.edu.pl/cas/logout?service='
    | Empty is fine
    |
    */
    'cas_logout_uri' => env('CAS_LOGOUT_URI', ''),
    /*
    |--------------------------------------------------------------------------
    | CAS Validation
    |--------------------------------------------------------------------------
    |
    | CAS server SSL validation: 'self' for self-signed certificate, 'ca' for
    | certificate from a CA, empty for no SSL validation
    |
    */

    'cas_validation' => env('CAS_VALIDATION', ''),
    /*
    |--------------------------------------------------------------------------
    | CAS Certificate
    |--------------------------------------------------------------------------
    |
    | Path to the CAS certificate file
    |
    */

    'cas_cert' => env('CAS_CERT', ''),
    /*
    |--------------------------------------------------------------------------
    | Use SAML to retrieve user attributes
    |--------------------------------------------------------------------------
    |
    | CAS can be configured to return more than just the username to a given
    | service. It could for example use an LDAP backend to return the first name,
    | last name, and email of the user. This can be activated on the client side
    | by setting 'cas_saml' to true
    |
    */

    'cas_saml' => env('CAS_SAML', false),
    /*
    |--------------------------------------------------------------------------
    | SAML group name attribute
    |--------------------------------------------------------------------------
    |
    | If you are using SAML with LDAP backend you can simply check if logged
    | user is member of specific group. Type below LDAP's group attribute
    | name
    |
    */
    'cas_saml_attr_groups' => env('CAS_SAML_ATTR_GROUPS', 'Groups'),
    /*
    |--------------------------------------------------------------------------
    | CAS session name
    |--------------------------------------------------------------------------
    |
    | Define your CAS session name
    |
    */
    'cas_session_name' => env('CAS_SESSION_NAME', 'CAS_SESSION'),

];
