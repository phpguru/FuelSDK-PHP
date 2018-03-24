<?php

namespace FuelSdk;

use \stdClass;

/**
 *  This utility class performs all the REST operation over CURL.
 */
class ET_Util
{
    /**
     * Function for calling a Fuel API using GET
     *
     * @param string $url The resource URL for the REST API
     * @param ET_Client $authStub The ET client object which performs the auth token, refresh token using clientID clientSecret
     * @return string     The response payload from the REST service
     */
    public static function restGet($url, $authStub, $isAuthConnection = "")
    {
        $ch = curl_init();
        $headers = ["User-Agent: " . self::getSDKVersion()];

        if ($isAuthConnection !== "") {
            $authorization = "Authorization: Bearer " . $isAuthConnection;
            $headers = [
                "User-Agent: " . self::getSDKVersion(),
                $authorization,
            ];
            //echo "inside GET auth conn\n";
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // Uses the URL passed in that is specific to the API used
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        // Need to set ReturnTransfer to True in order to store the result in a variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disable VerifyPeer for SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //proxy setting
        if (!empty($authStub->proxyHost)) {
            curl_setopt($ch, CURLOPT_PROXY, $authStub->proxyHost);
        }
        if (!empty($authStub->proxyPort)) {
            curl_setopt($ch, CURLOPT_PROXYPORT, $authStub->proxyPort);
        }
        if (!empty($authStub->proxyUserName) && !empty($authStub->proxyPassword)) {
            curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $authStub->proxyUserName . ':' . $authStub->proxyPassword);
        }

        $outputJSON = curl_exec($ch);
        $responseObject = new stdClass();
        $responseObject->body = $outputJSON;
        $responseObject->httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $responseObject;
    }

    /**
     * Function for calling a Fuel API using POST
     * @param string $url The resource URL for the REST API
     * @param string $content A string of JSON which will be passed to the REST API
     * @param ET_Client $authStub The ET client object which performs the auth token, refresh token using clientID clientSecret
     * @return string     The response payload from the REST service
     */
    public static function restPost($url, $content, $authStub, $isAuthConnection = "")
    {
        $ch = curl_init();

        // Uses the URL passed in that is specific to the API used
        curl_setopt($ch, CURLOPT_URL, $url);

        // When posting to a Fuel API, content-type has to be explicitly set to application/json
        $headers = [
            "Content-Type: application/json",
            "User-Agent: " . self::getSDKVersion(),
        ];
        if ($isAuthConnection !== "") {
            $authorization = "Authorization: Bearer " . $isAuthConnection;
            $headers = [
                "Content-Type: application/json",
                "User-Agent: " . self::getSDKVersion(),
                $authorization,
            ];
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // The content is the JSON payload that defines the request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);

        //Need to set ReturnTransfer to True in order to store the result in a variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disable VerifyPeer for SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //proxy setting
        if (!empty($authStub->proxyHost)) {
            curl_setopt($ch, CURLOPT_PROXY, $authStub->proxyHost);
        }
        if (!empty($authStub->proxyPort)) {
            curl_setopt($ch, CURLOPT_PROXYPORT, $authStub->proxyPort);
        }
        if (!empty($authStub->proxyUserName) && !empty($authStub->proxyPassword)) {
            curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $authStub->proxyUserName . ':' . $authStub->proxyPassword);
        }

        $outputJSON = curl_exec($ch);
        $responseObject = new stdClass();
        $responseObject->body = $outputJSON;
        $responseObject->httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $responseObject;
    }

    /**
     * Function for calling a Fuel API using PATCH
     * @param string $url The resource URL for the REST API
     * @param string $content A string of JSON which will be passed to the REST API
     * @param ET_Client $authStub The ET client object which performs the auth token, refresh token using clientID clientSecret
     * @return string     The response payload from the REST service
     */
    public static function restPatch($url, $content, $authStub, $isAuthConnection = "")
    {
        $ch = curl_init();

        // Uses the URL passed in that is specific to the API used
        curl_setopt($ch, CURLOPT_URL, $url);

        // When posting to a Fuel API, content-type has to be explicitly set to application/json
        $headers = [
            "Content-Type: application/json",
            "User-Agent: " . self::getSDKVersion(),
        ];
        if ($isAuthConnection !== "") {
            $authorization = "Authorization: Bearer " . $isAuthConnection;
            $headers = [
                "Content-Type: application/json",
                "User-Agent: " . self::getSDKVersion(),
                $authorization,
            ];
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // The content is the JSON payload that defines the request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);

        //Need to set ReturnTransfer to True in order to store the result in a variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Need to set the request to be a PATCH
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");

        // Disable VerifyPeer for SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //proxy setting
        if (!empty($authStub->proxyHost)) {
            curl_setopt($ch, CURLOPT_PROXY, $authStub->proxyHost);
        }
        if (!empty($authStub->proxyPort)) {
            curl_setopt($ch, CURLOPT_PROXYPORT, $authStub->proxyPort);
        }
        if (!empty($authStub->proxyUserName) && !empty($authStub->proxyPassword)) {
            curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $authStub->proxyUserName . ':' . $authStub->proxyPassword);
        }

        $outputJSON = curl_exec($ch);
        $responseObject = new stdClass();
        $responseObject->body = $outputJSON;
        $responseObject->httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $responseObject;
    }

    /**
     * Function for calling a Fuel API using PATCH
     * @param string $url The resource URL for the REST API
     * @param string $content A string of JSON which will be passed to the REST API
     * @param ET_Client $authStub The ET client object which performs the auth token, refresh token using clientID clientSecret
     * @return string     The response payload from the REST service
     */
    public static function restPut($url, $content, $authStub, $isAuthConnection = "")
    {
        $ch = curl_init();

        // Uses the URL passed in that is specific to the API used
        curl_setopt($ch, CURLOPT_URL, $url);

        // When posting to a Fuel API, content-type has to be explicitly set to application/json
        $headers = [
            "Content-Type: application/json",
            "User-Agent: " . self::getSDKVersion(),
        ];
        if ($isAuthConnection !== "") {
            $authorization = "Authorization: Bearer " . $isAuthConnection;
            $headers = [
                "Content-Type: application/json",
                "User-Agent: " . self::getSDKVersion(),
                $authorization,
            ];
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // The content is the JSON payload that defines the request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);

        //Need to set ReturnTransfer to True in order to store the result in a variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Need to set the request to be a PATCH
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

        // Disable VerifyPeer for SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //proxy setting
        if (!empty($authStub->proxyHost)) {
            curl_setopt($ch, CURLOPT_PROXY, $authStub->proxyHost);
        }
        if (!empty($authStub->proxyPort)) {
            curl_setopt($ch, CURLOPT_PROXYPORT, $authStub->proxyPort);
        }
        if (!empty($authStub->proxyUserName) && !empty($authStub->proxyPassword)) {
            curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $authStub->proxyUserName . ':' . $authStub->proxyPassword);
        }

        $outputJSON = curl_exec($ch);
        $responseObject = new stdClass();
        $responseObject->body = $outputJSON;
        $responseObject->httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $responseObject;
    }

    /**
     * Function for calling a Fuel API using DELETE
     * @param string $url The resource URL for the REST API
     * @param ET_Client $authStub The ET client object which performs the auth token, refresh token using clientID clientSecret
     * @return string     The response payload from the REST service
     */
    public static function restDelete($url, $authStub, $isAuthConnection = "")
    {
        $ch = curl_init();

        $headers = ["User-Agent: " . self::getSDKVersion()];
        if ($isAuthConnection !== "") {
            $authorization = "Authorization: Bearer " . $isAuthConnection;
            $headers = [
                "Content-Type: application/json",
                "User-Agent: " . self::getSDKVersion(),
                $authorization,
            ];
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Uses the URL passed in that is specific to the API used
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        // Need to set ReturnTransfer to True in order to store the result in a variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disable VerifyPeer for SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Set CustomRequest up for Delete	
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        //proxy setting
        if (!empty($authStub->proxyHost)) {
            curl_setopt($ch, CURLOPT_PROXY, $authStub->proxyHost);
        }
        if (!empty($authStub->proxyPort)) {
            curl_setopt($ch, CURLOPT_PROXYPORT, $authStub->proxyPort);
        }
        if (!empty($authStub->proxyUserName) && !empty($authStub->proxyPassword)) {
            curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $authStub->proxyUserName . ':' . $authStub->proxyPassword);
        }

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $outputJSON = curl_exec($ch);

        $responseObject = new stdClass();
        $responseObject->body = $outputJSON;
        $responseObject->httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $responseObject;
    }

    /**
     * @param array $array The array
     * @return bool      Returns true if the parameter array is dictionary type array, false otherwise.
     */
    public static function isAssoc($array)
    {
        return ($array !== array_values($array));
    }

    /**
     * Print debugging message to the browser or cli
     * @param $message mixed string | array | object
     */
    public static function printDebugInfo($message)
    {
        if (php_sapi_name() == 'cli') {
            self::printDebugInfoToCli(self::convertArrayOrObjectToJson($message));
        } else {
            self::printDebugInfoToBrowser(self::convertArrayOrObjectToJson($message));
        }
    }

    /**
     * Print to CLI - no pre tags
     * @param $message mixed string | array | object
     */
    private static function printDebugInfoToCli($message)
    {
        echo $message . PHP_EOL;
    }

    /**
     * Print to browser - include pre tags
     * @param $message mixed string | array | object
     */
    private static function printDebugInfoToBrowser($message)
    {
        echo "<pre>" .PHP_EOL;
        echo $message .PHP_EOL;
        echo "</pre>" .PHP_EOL;
    }

    private static function convertArrayOrObjectToJson($message)
    {
        if (is_array($message) || is_object($message)) {
            return json_encode($message);
        }
        return $message;
    }

    /**
     * This method will not change until a major release.
     *
     * @api
     *
     * @return string
     */
    public static function getSDKVersion()
    {
        return "FuelSDK-PHP-v1.1.0";
    }

}
