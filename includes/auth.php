<?php namespace CarmaAPI\config\auth;

interface APIAuthentification {
    // Will be called once, before proceeding to any API request
    public function performAuthentification(\Httpful\Request $_req);

    // Will be called once, just before destructing the api object
    public function performDeAuthentification();
}

class RESTBasicAPIAuthentification implements APIAuthentification {
    private $api_username;
    private $api_password;

    public function __construct($_api_username, $_api_password)
    {
        $this->api_username = $_api_username;
        $this->api_password = $_api_password;
    }

    /**
     * @param \Httpful\Request $_req
     * @return \Httpful\Request
     */
    public function performAuthentification(\Httpful\Request $_req)
    {
        return $_req->authenticateWith($this->api_username, $this->api_password);
    }

    public function performDeAuthentification()
    {
        // Nothing to do here
    }
}