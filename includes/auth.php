<?php namespace CarmaAPI\config\auth;

interface APIAuthentification {
    public function getHttpHeaders();

    // Will be called once, before proceeding to any API request
    public function performAuthentification($_http_client);

    // Will be called once, just before destructing the api object
    public function performDeAuthentification($_http_client);
}

class RESTBasicAPIAuthentification implements APIAuthentification {
    private $api_username;
    private $api_password;

    public function __construct($_api_username, $_api_password)
    {
        $this->api_username = $_api_username;
        $this->api_password = $_api_password;
    }

    public function getHttpHeaders()
    {
        // TODO: provide basic auth headers
    }

    public function performAuthentification($_http_client)
    {
        // Nothing to do here
    }

    public function performDeAuthentification($_http_client)
    {
        // Nothing to do here
    }
}