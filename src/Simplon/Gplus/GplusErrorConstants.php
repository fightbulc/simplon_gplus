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
    }