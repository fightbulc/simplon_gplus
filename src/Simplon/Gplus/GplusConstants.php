<?php

    namespace Simplon\Gplus;

    class GplusConstants
    {
        CONST DOMAIN_API = 'https://www.googleapis.com';
        CONST DOMAIN_ACCOUNTS = 'https://accounts.google.com';

        // --------------------------------------

        CONST AUTH_SCOPE_EMAIL = 'email';
        CONST AUTH_SCOPE_PROFILE = 'profile';

        // --------------------------------------

        CONST PATH_OAUTH_ACCOUNT = '/o/oauth2/auth';
        CONST PATH_OAUTH_TOKEN = '/o/oauth2/token';
        CONST PATH_VERIFY_ACCESS_TOKEN = 'oauth2/v1/tokeninfo';
        CONST PATH_PEOPLE_DETAILS = '/plus/v1/people/{userId}';
    }