<?php

    namespace Simplon\Gplus\Vo;

    class GplusAuthVo
    {
        protected $_clientId;
        protected $_clientSecret;
        protected $_urlRedirect;

        // ######################################

        /**
         * @param array $data
         *
         * @return GplusAuthVo
         */
        public function setData(array $data)
        {
            $this
                ->setClientId($data['clientId'])
                ->setClientSecret($data['clientSecret'])
                ->setUrlRedirect($data['urlRedirect']);

            return $this;
        }

        // ######################################

        /**
         * @param mixed $urlRedirect
         *
         * @return GplusAuthVo
         */
        public function setUrlRedirect($urlRedirect)
        {
            $this->_urlRedirect = $urlRedirect;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getUrlRedirect()
        {
            return (string)$this->_urlRedirect;
        }

        // ######################################

        /**
         * @param mixed $clientId
         *
         * @return GplusAuthVo
         */
        public function setClientId($clientId)
        {
            $this->_clientId = $clientId;

            return $this;
        }

        /**
         * @return string
         */
        public function getClientId()
        {
            return (string)$this->_clientId;
        }

        /**
         * @param mixed $clientSecret
         *
         * @return GplusAuthVo
         */
        public function setClientSecret($clientSecret)
        {
            $this->_clientSecret = $clientSecret;

            return $this;
        }

        /**
         * @return string
         */
        public function getClientSecret()
        {
            return (string)$this->_clientSecret;
        }
    }