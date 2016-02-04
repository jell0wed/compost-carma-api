<?php namespace CarmaAPI;

define("ENDPOINT_LISTS", "lists");

require_once(dirname(__FILE__) . "/API-endpoints.php");
require_once(dirname(__FILE__) . "/endpoints/ListEndpoint.php");

use CarmaAPI\config\APIConfig;
use CarmaAPI\endpoints;

class CarmaAPI {
    private $config;
    private $loaded_endpoints = array();

    public function __construct(APIConfig $_conf)
    {
        $this->config = $_conf;
        $this->initializeEndpoints();
    }

    private function initializeEndpoints() {
        $this->loaded_endpoints[ENDPOINT_LISTS] = new endpoints\ListsEndpoint($this);
    }

    public function lists() {
        return $this->loaded_endpoints[ENDPOINT_LISTS];
    }

    public function getRequest() {

    }
}