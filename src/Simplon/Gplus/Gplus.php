<?php

    namespace Simplon\Gplus;

    use Simplon\Gplus\Vo\GplusAuthVo;
    use Simplon\Gplus\Vo\GplusPersonVo;
    use Simplon\Gplus\Vo\GplusRefreshAccessTokenVo;
    use Simplon\Gplus\Vo\GplusRequestAccessTokenVo;
    use Simplon\Gplus\Vo\GplusVerifyTokenVo;

    class Gplus
    {
        protected $_authVo;

        protected $_scopeValid = [
            GplusConstants::AUTH_SCOPE_EMAIL,
            GplusConstants::AUTH_SCOPE_PROFILE,
        ];

        // ######################################

        /**
         * @param GplusAuthVo $authVo
         */
        public function __construct(GplusAuthVo $authVo)
        {
            $this->_authVo = $authVo;
        }

        // ######################################

        /**
         * @return GplusAuthVo
         */
        protected function _getAuthVo()
        {
            return $this->_authVo;
        }

        // ######################################

        /**
         * @param array $scope
         *
         * @return string
         * @throws GplusException
         */
        public function getAuthUrl($scope = [])
        {
            if (empty($scope))
            {
                throw new GplusException(
                    GplusErrorConstants::AUTH_MISSING_SCOPE_MESSAGE,
                    GplusErrorConstants::AUTH_MISSING_SCOPE_CODE
                );
            }

            $clientId = $this
                ->_getAuthVo()
                ->getClientId();

            $urlRedirect = $this->_getAuthVo()
                ->getUrlRedirect();

            $params = [
                'scope'           => join(' ', $scope),
                'redirect_uri'    => $urlRedirect,
                'client_id'       => $clientId,
                'state'           => 'auth',
                'response_type'   => 'code',
                'approval_prompt' => 'force',
                'access_type'     => 'offline',
            ];

            return trim(GplusConstants::DOMAIN_ACCOUNTS, '/') . '/' . trim(GplusConstants::PATH_OAUTH_ACCOUNT, '/') . '?' . http_build_query($params);
        }

        // ######################################

        /**
         * @param $code
         *
         * @return bool|GplusRequestAccessTokenVo
         * @throws GplusException
         */
        public function requestAccessToken($code)
        {
            if (empty($code))
            {
                throw new GplusException(
                    GplusErrorConstants::AUTH_MISSING_CODE_MESSAGE,
                    GplusErrorConstants::AUTH_MISSING_CODE_CODE
                );
            }

            $clientId = $this
                ->_getAuthVo()
                ->getClientId();

            $clientSecret = $this
                ->_getAuthVo()
                ->getClientSecret();

            $urlRedirect = $this->_getAuthVo()
                ->getUrlRedirect();

            $params = [
                'code'          => $code,
                'redirect_uri'  => $urlRedirect,
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'grant_type'    => 'authorization_code',
            ];

            $response = GplusRequest::post(GplusConstants::PATH_OAUTH_TOKEN, $params);

            if ($response !== FALSE)
            {
                return new GplusRequestAccessTokenVo($response);
            }

            return FALSE;
        }

        // ######################################

        /**
         * @param $refreshToken
         *
         * @return bool|GplusRefreshAccessTokenVo
         * @throws GplusException
         */
        public function refreshAccessToken($refreshToken)
        {
            if (empty($refreshToken))
            {
                throw new GplusException(
                    GplusErrorConstants::AUTH_REFRESH_ACCESSTOKEN_MESSAGE,
                    GplusErrorConstants::AUTH_REFRESH_ACCESSTOKEN_CODE
                );
            }

            $clientId = $this
                ->_getAuthVo()
                ->getClientId();

            $clientSecret = $this
                ->_getAuthVo()
                ->getClientSecret();

            $params = [
                'refresh_token' => $refreshToken,
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'grant_type'    => 'refresh_token',
            ];

            try
            {
                $response = GplusRequest::post(GplusConstants::PATH_OAUTH_TOKEN, $params);

                if ($response !== FALSE)
                {
                    return new GplusRefreshAccessTokenVo($response);
                }
            }
            catch (GplusException $e)
            {
                throw new GplusException(
                    GplusErrorConstants::FAILED_REFRESHING_ACCESSTOKEN_MESSAGE . $e->getErrors()['error'],
                    GplusErrorConstants::FAILED_REFRESHING_ACCESSTOKEN_CODE
                );
            }

            return FALSE;
        }

        // ######################################

        /**
         * @param $accessToken
         * @param null $refreshToken
         *
         * @return bool|GplusVerifyTokenVo
         * @throws GplusException
         */
        public function verifyAccessToken($accessToken, $refreshToken = NULL)
        {
            $params = [
                'access_token' => $accessToken,
            ];

            try
            {
                $response = GplusRequest::get(GplusConstants::PATH_VERIFY_ACCESS_TOKEN, $params);

                if ($response !== FALSE)
                {
                    return (new GplusVerifyTokenVo($response))->setAccessToken($accessToken);
                }
            }
            catch (GplusException $e)
            {
                /**
                 * If we reached this point then our accessToken might be invalid.
                 * Therefore, try to refresh accessToken if a refreshToken was passed along.
                 *
                 * Else, we just throw an Exception.
                 */

                try
                {
                    if ($refreshToken !== NULL)
                    {
                        // try to refresh accessToken
                        $gplusRefreshAccessTokenVo = $this->refreshAccessToken($refreshToken);

                        // verify again
                        return $this
                            ->verifyAccessToken($gplusRefreshAccessTokenVo->getAccessToken())
                            ->setIsNewAccessToken(TRUE);
                    }
                }
                catch (GplusException $e)
                {
                }

                throw new GplusException(
                    GplusErrorConstants::AUTH_INVALID_ACCESSTOKEN_MESSAGE,
                    GplusErrorConstants::AUTH_INVALID_ACCESSTOKEN_CODE,
                    $e->getMessage()
                );
            }

            return FALSE;
        }

        // ######################################

        /**
         * @param $accessToken
         * @param $refreshToken
         *
         * @return bool|GplusPersonVo
         * @throws GplusException
         */
        public function getUserDetails($accessToken, $refreshToken)
        {
            $gplusVerifyTokenVo = $this->verifyAccessToken($accessToken, $refreshToken);

            // ----------------------------------

            $params = [
                'access_token' => $gplusVerifyTokenVo->getAccessToken(),
            ];

            // build path with userId
            $path = str_replace('{userId}', $gplusVerifyTokenVo->getUserId(), GplusConstants::PATH_PEOPLE_DETAILS);

            try
            {
                // request
                $response = GplusRequest::get($path, $params);

                if ($response !== FALSE)
                {
                    return (new GplusPersonVo($response))
                        ->setAccessToken($gplusVerifyTokenVo->getAccessToken())
                        ->setRefreshToken($refreshToken)
                        ->setIsNewAccessToken($gplusVerifyTokenVo->isNewAccessToken());
                }
            }
            catch (GplusException $e)
            {
                throw new GplusException(
                    GplusErrorConstants::FAILED_FETCHING_USER_DETAILS_MESSAGE,
                    GplusErrorConstants::FAILED_FETCHING_USER_DETAILS_CODE,
                    $e->getMessage()
                );
            }

            return FALSE;
        }
    }