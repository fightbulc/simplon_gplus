<?php

    namespace Simplon\Gplus\Vo;

    use Simplon\Helper\VoSetDataFactory;

    class GplusVerifyTokenVo
    {
        protected $_issuedTo;
        protected $_audience;
        protected $_userId;
        protected $_scope;
        protected $_expiresIn;
        protected $_email;
        protected $_verifiedEmail;
        protected $_accessType;
        protected $_accessToken;
        protected $_isNewAccessToken;

        // ######################################

        /**
         * @param array $data
         */
        public function __construct(array $data)
        {
            (new VoSetDataFactory())
                ->setRawData($data)
                ->setConditionByKey('issued_to', function ($val) { $this->setIssuedTo($val); })
                ->setConditionByKey('audience', function ($val) { $this->setAudience($val); })
                ->setConditionByKey('user_id', function ($val) { $this->setUserId($val); })
                ->setConditionByKey('scope', function ($val) { $this->setScope($val); })
                ->setConditionByKey('expires_in', function ($val) { $this->setExpiresIn($val); })
                ->setConditionByKey('email', function ($val) { $this->setEmail($val); })
                ->setConditionByKey('verified_email', function ($val) { $this->setVerifiedEmail($val); })
                ->setConditionByKey('access_type', function ($val) { $this->setAccessType($val); })
                ->run();
        }

        // ######################################

        /**
         * @param mixed $accessToken
         *
         * @return GplusVerifyTokenVo
         */
        public function setAccessToken($accessToken)
        {
            $this->_accessToken = $accessToken;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getAccessToken()
        {
            return (string)$this->_accessToken;
        }

        // ######################################

        /**
         * @param mixed $isNewAccessToken
         *
         * @return GplusVerifyTokenVo
         */
        public function setIsNewAccessToken($isNewAccessToken)
        {
            $this->_isNewAccessToken = $isNewAccessToken;

            return $this;
        }

        // ######################################

        /**
         * @return bool
         */
        public function getIsNewAccessToken()
        {
            return $this->_isNewAccessToken === TRUE ? TRUE : FALSE;
        }

        // ######################################

        /**
         * @param mixed $accessType
         *
         * @return GplusVerifyTokenVo
         */
        public function setAccessType($accessType)
        {
            $this->_accessType = $accessType;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getAccessType()
        {
            return (string)$this->_accessType;
        }

        // ######################################

        /**
         * @param mixed $audience
         *
         * @return GplusVerifyTokenVo
         */
        public function setAudience($audience)
        {
            $this->_audience = $audience;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getAudience()
        {
            return (string)$this->_audience;
        }

        // ######################################

        /**
         * @param mixed $email
         *
         * @return GplusVerifyTokenVo
         */
        public function setEmail($email)
        {
            $this->_email = $email;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getEmail()
        {
            return (string)$this->_email;
        }

        // ######################################

        /**
         * @param mixed $expiresIn
         *
         * @return GplusVerifyTokenVo
         */
        public function setExpiresIn($expiresIn)
        {
            $this->_expiresIn = $expiresIn;

            return $this;
        }

        // ######################################

        /**
         * @return int
         */
        public function getExpiresIn()
        {
            return (int)$this->_expiresIn;
        }

        // ######################################

        /**
         * @return bool
         */
        public function isValidToken()
        {
            return $this->getExpiresIn() > 0 ? TRUE : FALSE;
        }

        // ######################################

        /**
         * @param mixed $issuedTo
         *
         * @return GplusVerifyTokenVo
         */
        public function setIssuedTo($issuedTo)
        {
            $this->_issuedTo = $issuedTo;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getIssuedTo()
        {
            return (string)$this->_issuedTo;
        }

        // ######################################

        /**
         * @param mixed $scope
         *
         * @return GplusVerifyTokenVo
         */
        public function setScope($scope)
        {
            $this->_scope = $scope;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getScope()
        {
            return (string)$this->_scope;
        }

        // ######################################

        /**
         * @return array
         */
        public function getScopeAsArray()
        {
            return explode(' ', $this->getScope());
        }

        // ######################################

        /**
         * @param mixed $userId
         *
         * @return GplusVerifyTokenVo
         */
        public function setUserId($userId)
        {
            $this->_userId = $userId;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getUserId()
        {
            return (string)$this->_userId;
        }

        // ######################################

        /**
         * @param mixed $verifiedEmail
         *
         * @return GplusVerifyTokenVo
         */
        public function setVerifiedEmail($verifiedEmail)
        {
            $this->_verifiedEmail = $verifiedEmail;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getVerifiedEmail()
        {
            return (string)$this->_verifiedEmail;
        }
    }