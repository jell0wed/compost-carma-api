<?php namespace CarmaAPI\config;
define("CARMA_REST_ENDPOINT", "carmamail.com/rest");

interface APIConfig {
    public function getBaseAPIUrl();
    public function getAPIEndpointUrl($endpoint);
}

class RESTAPIConfig implements APIConfig{
    private $server_no;
    private $customer_id;
    private $auth;

    public function __construct($_server_no, $_customer_id) {
        $this->server_no = $_server_no;
        $this->customer_id = $_customer_id;
    }

    public function setAuthentification($_auth) {
        $this->auth = $_auth;
    }

    public function getBaseAPIUrl() {
        return "http://" . $this->server_no . "." . CARMA_REST_ENDPOINT . "/" . $this->customer_id;
    }

    public function getAPIEndpointUrl($endpoint)
    {
        return $this->getBaseAPIUrl() . $endpoint;
    }
}