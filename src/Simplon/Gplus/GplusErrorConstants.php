<?php

    namespace Simplon\Gplus;

    class GplusErrorConstants
    {
        CONST REQUEST_ERROR_CODE = 1;
        CONST REQUEST_ERROR_MESSAGE = 'A request error occured';

        CONST AUTH_MISSING_SCOPE_CODE = 2;
        CONST AUTH_MISSING_SCOPE_MESSAGE = 'Missing scope.';

        CONST AUTH_MISSING_CODE_CODE = 3;
        CONST AUTH_MISSING_CODE_MESSAGE = 'Code is required for accessToken exchange.';

        CONST AUTH_REFRESH_ACCESSTOKEN_CODE = 4;
        CONST AUTH_REFRESH_ACCESSTOKEN_MESSAGE = 'RefreshToken is required for receiving a new accessToken.';

        CONST AUTH_INVALID_ACCESSTOKEN_CODE = 5;
        CONST AUTH_INVALID_ACCESSTOKEN_MESSAGE = 'The given accessToken is invalid: either it expired or the user revoked the permissions.';

        CONST FAILED_FETCHING_USER_DETAILS_CODE = 6;
        CONST FAILED_FETCHING_USER_DETAILS_MESSAGE = 'An error occured while trying to fetch the user details.';

        CONST FAILED_REFRESHING_ACCESSTOKEN_CODE = 7;
        CONST FAILED_REFRESHING_ACCESSTOKEN_MESSAGE = 'Failed to refresh accessToken. Message received: ';
    }