<?php

    namespace Simplon\Gplus;

    class GplusException extends \Exception
    {
        protected $errors;

        // ######################################

        /**
         * @param string $message
         * @param int $code
         * @param array $errors
         */
        public function __construct($message, $code = 0, $errors = [])
        {
            $this->message = $message;
            $this->code = $code;
            $this->errors = $errors;
        }

        // ######################################

        /**
         * @return array
         */
        public function getErrors()
        {
            return $this->errors;
        }
    }