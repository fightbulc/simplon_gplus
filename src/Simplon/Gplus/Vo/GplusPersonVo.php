<?php

    namespace Simplon\Gplus\Vo;

    use Simplon\Helper\VoSetDataFactory;

    class GplusPersonVo
    {
        protected $_rawData;
        protected $_accessToken;
        protected $_refreshToken;
        protected $_isNewAccessToken;
        protected $_id;
        protected $_displayName;
        protected $_emails;
        protected $_urlProfile;
        protected $_urlImage;
        protected $_gender;
        protected $_language;
        protected $_verified;

        // ######################################

        /**
         * @param array $data
         */
        public function __construct(array $data)
        {
            (new VoSetDataFactory())
                ->setRawData($data)
                ->setConditionByKey('id', function ($val) { $this->setId($val); })
                ->setConditionByKey('displayName', function ($val) { $this->setDisplayName($val); })
                ->setConditionByKey('emails', function ($val) { $this->setEmails($val); })
                ->setConditionByKey('url', function ($val) { $this->setUrlProfile($val); })
                ->setConditionByKey('image', function ($val) { $this->setUrlImage($val); })
                ->setConditionByKey('gender', function ($val) { $this->setGender($val); })
                ->setConditionByKey('language', function ($val) { $this->setLanguage($val); })
                ->setConditionByKey('verified', function ($val) { $this->setVerified($val); })
                ->run();

            $this->setRawData($data);
        }

        // ######################################

        /**
         * @param mixed $rawData
         *
         * @return GplusPersonVo
         */
        public function setRawData($rawData)
        {
            $this->_rawData = $rawData;

            return $this;
        }

        // ######################################

        /**
         * @return array
         */
        public function getRawData()
        {
            return (array)$this->_rawData;
        }

        // ######################################

        /**
         * @param mixed $accessToken
         *
         * @return GplusPersonVo
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
         * @param mixed $refreshToken
         *
         * @return GplusPersonVo
         */
        public function setRefreshToken($refreshToken)
        {
            $this->_refreshToken = $refreshToken;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getRefreshToken()
        {
            return (string)$this->_refreshToken;
        }

        // ######################################

        /**
         * @param mixed $isNewAccessToken
         *
         * @return GplusPersonVo
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
        public function isNewAccessToken()
        {
            return $this->_isNewAccessToken === TRUE ? TRUE : FALSE;
        }

        // ######################################

        /**
         * @param mixed $verified
         *
         * @return GplusPersonVo
         */
        public function setVerified($verified)
        {
            $this->_verified = $verified;

            return $this;
        }

        // ######################################

        /**
         * @return bool
         */
        public function getVerified()
        {
            return (bool)$this->_verified;
        }

        // ######################################

        /**
         * @return bool
         */
        public function isVerified()
        {
            return $this->getVerified() === TRUE ? TRUE : FALSE;
        }

        // ######################################

        /**
         * @param mixed $id
         *
         * @return GplusPersonVo
         */
        public function setId($id)
        {
            $this->_id = $id;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getId()
        {
            return (string)$this->_id;
        }

        // ######################################

        /**
         * @param mixed $displayName
         *
         * @return GplusPersonVo
         */
        public function setDisplayName($displayName)
        {
            $this->_displayName = $displayName;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getDisplayName()
        {
            return (string)$this->_displayName;
        }

        // ######################################

        /**
         * @param mixed $emails
         *
         * @return GplusPersonVo
         */
        public function setEmails(array $emails)
        {
            $this->_emails = $emails;

            return $this;
        }

        // ######################################

        /**
         * @return array
         */
        public function getEmails()
        {
            return (array)$this->_emails;
        }

        // ######################################

        /**
         * @return bool
         */
        public function getEmailAccount()
        {
            $emails = $this->getEmails();
            foreach ($emails as $email)
            {
                if ($email['type'] === 'account')
                {
                    return $email['value'];
                }
            }

            return FALSE;
        }

        // ######################################

        /**
         * @param mixed $gender
         *
         * @return GplusPersonVo
         */
        public function setGender($gender)
        {
            $this->_gender = $gender;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getGender()
        {
            return (string)$this->_gender;
        }

        // ######################################

        /**
         * @param mixed $language
         *
         * @return GplusPersonVo
         */
        public function setLanguage($language)
        {
            $this->_language = $language;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getLanguage()
        {
            return (string)$this->_language;
        }

        // ######################################

        /**
         * @param mixed $urlImage
         *
         * @return GplusPersonVo
         */
        public function setUrlImage(array $urlImage)
        {
            $this->_urlImage = $urlImage['url'];

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getUrlImage()
        {
            return (string)$this->_urlImage;
        }

        // ######################################

        /**
         * @param int $squareSizePixel
         *
         * @return string
         */
        public function getUrlImageBySize($squareSizePixel = 50)
        {
            $image = preg_replace('/sz=\d+/', '', $this->getUrlImage());

            return $image . 'sz=' . $squareSizePixel;
        }

        // ######################################

        /**
         * @param mixed $urlProfile
         *
         * @return GplusPersonVo
         */
        public function setUrlProfile($urlProfile)
        {
            $this->_urlProfile = $urlProfile;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getUrlProfile()
        {
            return (string)$this->_urlProfile;
        }
    }