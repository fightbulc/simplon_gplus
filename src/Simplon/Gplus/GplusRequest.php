<?php

    namespace Simplon\Gplus;

    class GplusRequest
    {
        /**
         * @param $domain
         *
         * @return string
         */
        protected static function _getCleanDomain($domain)
        {
            return trim($domain, '/');
        }

        // ######################################

        /**
         * @param $path
         *
         * @return string
         */
        protected static function _getCleanPath($path)
        {
            return trim($path, '/');
        }

        // ######################################

        /**
         * @param $params
         *
         * @return string
         */
        protected static function _generateQuery($params)
        {
            return http_build_query($params);
        }

        // ######################################

        /**
         * @param $path
         * @param array $params
         *
         * @return array|bool
         * @throws GplusException
         */
        public static function get($path, $params = [])
        {
            if (!empty($params))
            {
                $url = self::_getCleanDomain(GplusConstants::DOMAIN_API) . '/' . self::_getCleanPath($path) . '?' . self::_generateQuery($params);

                // talk to google
                $responseJson = \CURL::init($url)
                    ->setReturnTransfer(TRUE)
                    ->execute();

                // parse response
                $response = json_decode($responseJson, TRUE);

                if ($response !== NULL)
                {
                    if (isset($response['error']))
                    {
                        throw new GplusException($response);
                    }

                    return (array)$response;
                }
            }

            return FALSE;
        }

        // ######################################

        /**
         * @param $path
         * @param array $params
         *
         * @return array|bool
         * @throws GplusException
         */
        public static function post($path, $params = [])
        {
            if (!empty($params))
            {
                $url = self::_getCleanDomain(GplusConstants::DOMAIN_ACCOUNTS) . '/' . self::_getCleanPath($path);

                // talk to google
                $responseJson = \CURL::init($url)
                    ->setPostFields(http_build_query($params))
                    ->setReturnTransfer(TRUE)
                    ->execute();

                // parse response
                $response = json_decode($responseJson, TRUE);

                if ($response !== NULL)
                {
                    if (isset($response['error']))
                    {
                        throw new GplusException(
                            GplusErrorConstants::REQUEST_ERROR_MESSAGE,
                            GplusErrorConstants::REQUEST_ERROR_CODE,
                            $responseJson
                        );
                    }

                    return (array)$response;
                }
            }

            return FALSE;
        }
    }