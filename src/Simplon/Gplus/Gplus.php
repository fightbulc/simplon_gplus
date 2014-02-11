<?php

    namespace Simplon\Gplus;

    use Simplon\Gplus\Vo\GplusAuthVo;
    use Simplon\Gplus\Vo\GplusPersonVo;
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
                'scope'         => join(' ', $scope),
                'redirect_uri'  => $urlRedirect,
                'client_id'     => $clientId,
                'state'         => 'auth',
                'response_type' => 'code',
                'access_type'   => 'offline',
            ];

            return trim(GplusConstants::DOMAIN_ACCOUNTS, '/') . '/' . trim(GplusConstants::PATH_OAUTH_ACCOUNT) . '?' . http_build_query($params);
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
         * @param $accessToken
         *
         * @return bool|GplusVerifyTokenVo
         */
        public function verifyAccessToken($accessToken)
        {
            $params = [
                'access_token' => $accessToken,
            ];

            $response = GplusRequest::get(GplusConstants::PATH_VERIFY_ACCESS_TOKEN, $params);

            if ($response !== FALSE)
            {
                return new GplusVerifyTokenVo($response);
            }

            return FALSE;
        }

        // ######################################

        /**
         * @param $userId
         * @param $accessToken
         *
         * @return bool|GplusPersonVo
         */
        public function getUserDetails($userId, $accessToken)
        {
            $params = [
                'access_token' => $accessToken,
            ];

            // build path with userId
            $path = str_replace('{userId}', $userId, GplusConstants::PATH_PEOPLE_DETAILS);

            // request
            $response = GplusRequest::get($path, $params);

            if ($response !== FALSE)
            {
                return new GplusPersonVo($response);
            }

            return FALSE;
        }
    }