<?php

    namespace Simplon\Gplus\Vo;

    use Simplon\Gplus\GplusConstants;
    use Simplon\Helper\VoSetDataFactory;

    class GplusAuthVo
    {
        protected $_clientId;
        protected $_clientSecret;
        protected $_urlRedirect;
        protected $_approvalPrompt = GplusConstants::APPROVAL_PROMPT_AUTO;

        // ######################################

        /**
         * @param array $data
         *
         * @return GplusAuthVo
         */
        public function setData(array $data)
        {
            (new VoSetDataFactory())
                ->setRawData($data)
                ->setConditionByKey('clientId', function ($val) { $this->setClientId($val); })
                ->setConditionByKey('clientSecret', function ($val) { $this->setClientSecret($val); })
                ->setConditionByKey('urlRedirect', function ($val) { $this->setUrlRedirect($val); })
                ->run();

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

        // ######################################

        /**
         * @return string
         */
        public function getClientId()
        {
            return (string)$this->_clientId;
        }

        // ######################################

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

        // ######################################

        /**
         * @return string
         */
        public function getClientSecret()
        {
            return (string)$this->_clientSecret;
        }

        // ######################################

        /**
         * @return GplusAuthVo
         */
        public function forceApprovalPrompt()
        {
            $this->_approvalPrompt = GplusConstants::APPROVAL_PROMPT_FORCE;

            return $this;
        }

        // ######################################

        /**
         * @return GplusAuthVo
         */
        public function autoApprovalPrompt()
        {
            $this->_approvalPrompt = GplusConstants::APPROVAL_PROMPT_AUTO;

            return $this;
        }

        // ######################################

        /**
         * @return string
         */
        public function getApprovalPrompt()
        {
            return $this->_approvalPrompt;
        }
    }