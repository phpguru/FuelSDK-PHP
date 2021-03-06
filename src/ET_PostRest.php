<?php

namespace FuelSdk;

/**
 * This class represents the POST operation for REST service.
 */
class ET_PostRest extends ET_Constructor
{
    /**
     * Initializes a new instance of the class.
     * @param    ET_Client $authStub The ET client object which performs the auth token, refresh token using clientID clientSecret
     * @param    string $url The endpoint URL
     * @param    array $props Dictionary type array which may hold e.g. array('id' => '', 'key' => '')
     */
    function __construct($authStub, $url, $props, $qs = "")
    {
        // $restResponse = ET_Util::restPost($url, json_encode($props), $authStub);
        $restResponse = ET_Util::restPost($url, json_encode($props), $authStub, $qs);
        parent::__construct($restResponse->body, $restResponse->httpcode, true);
    }
}
