<?php namespace CarmaAPI\config;
use CarmaAPI\config\auth\APIAuthentification;

define("CARMA_REST_ENDPOINT", "carmamail.com/rest");

interface APIConfig {
    public function getBaseAPIUrl();
    public function getAPIEndpointUrl($endpoint);

    /**
     * @return APIAuthentification
     */
    public function getAuthentification();
    public function getHeaders();
}

class RESTAPIConfig implements APIConfig{
    private $server_no;
    private $customer_id;

    /**
     * @var APIAuthentification
     */
    private $auth;

    public function __construct($_server_no, $_customer_id) {
        $this->server_no = $_server_no;
        $this->customer_id = $_customer_id;
    }

    public function setAuthentification($_auth) {
        $this->auth = $_auth;
    }

    /**
     * @return APIAuthentification
     */
    public function getAuthentification() {
        if($this->auth == null) {
            throw new \Exception("You must specifiy a authentification mechanism in order to use CarmaAPI");
        }
        return $this->auth;
    }

    public function getBaseAPIUrl() {
        return "http://" . $this->server_no . "." . CARMA_REST_ENDPOINT . "/" . $this->customer_id;
    }

    public function getAPIEndpointUrl($endpoint)
    {
        return $this->getBaseAPIUrl() . $endpoint;
    }

    public function getHeaders()
    {
        return array("Accept" => "application/json");
    }
}