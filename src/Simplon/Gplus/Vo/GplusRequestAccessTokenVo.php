<?php

    namespace Simplon\Gplus\Vo;

    use Simplon\Helper\VoSetDataFactory;

    class GplusRequestAccessTokenVo
    {
        protected $_accessToken;
        protected $_tokenType;
        protected $_expiresIn;
        protected $_idToken;
        protected $_refreshToken;

        // ######################################

        /**
         * @param array $data
         */
        public function __construct(array $data)
        {
            (new VoSetDataFactory())
                ->setRawData($data)
                ->setConditionByKey('access_token', function ($val) { $this->setAccessToken($val); })
                ->setConditionByKey('token_type', function ($val) { $this->setTokenType($val); })
                ->setConditionByKey('expires_in', function ($val) { $this->setExpiresIn($val); })
                ->setConditionByKey('id_token', function ($val) { $this->setIdToken($val); })
                ->setConditionByKey('refresh_token', function ($val) { $this->setRefreshToken($val); })
                ->run();
        }

        // ######################################

        /**
         * @param mixed $accessToken
         *
         * @return GplusRequestAccessTokenVo
         */
        public function setAccessToken($accessToken)
        {
            $this->_accessToken = $accessToken;

            return $this;
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getAccessToken()
        {
            return (string)$this->_accessToken;
        }

        // ######################################

        /**
         * @param mixed $expiresIn
         *
         * @return GplusRequestAccessTokenVo
         */
        public function setExpiresIn($expiresIn)
        {
            $this->_expiresIn = $expiresIn;

            return $this;
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getExpiresIn()
        {
            return (int)$this->_expiresIn;
        }

        // ######################################

        /**
         * @param mixed $idToken
         *
         * @return GplusRequestAccessTokenVo
         */
        public function setIdToken($idToken)
        {
            $this->_idToken = $idToken;

            return $this;
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getIdToken()
        {
            return (string)$this->_idToken;
        }

        // ######################################

        /**
         * @param mixed $refreshToken
         *
         * @return GplusRequestAccessTokenVo
         */
        public function setRefreshToken($refreshToken)
        {
            $this->_refreshToken = $refreshToken;

            return $this;
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getRefreshToken()
        {
            return (string)$this->_refreshToken;
        }

        // ######################################

        /**
         * @param mixed $tokenType
         *
         * @return GplusRequestAccessTokenVo
         */
        public function setTokenType($tokenType)
        {
            $this->_tokenType = $tokenType;

            return $this;
        }

        // ######################################

        /**
         * @return mixed
         */
        public function getTokenType()
        {
            return (string)$this->_tokenType;
        }
    }