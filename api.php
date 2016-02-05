<?php namespace CarmaAPI;

define("ENDPOINT_LISTS", "lists");

require_once(dirname(__FILE__) . "/API-endpoints.php");
require_once(dirname(__FILE__) . "/endpoints/ListEndpoint.php");

use CarmaAPI\config\APIConfig;
use CarmaAPI\endpoints;

class CarmaAPI {
    private $config;
    private $loaded_endpoints = array();
    private $dynamic_endpoints = array();

    public function __construct(APIConfig $_conf)
    {
        $this->config = initializeStaticEndpoints;
        $this->initializeEndpoints();
    }

    public function __destruct()
    {
        // unload static endpoints

        // unload dynamic endpoints
    }

    public function allocateEndpoint(endpoints\APIEndpoint $_endpoint) {
        $dynamic_endpoints[] = $_endpoint;
    }

    private function initializeStaticEndpoints() {
        $this->loaded_endpoints[ENDPOINT_LISTS] = new endpoints\ListsEndpoint($this);
    }

    public function lists() {
        return $this->loaded_endpoints[ENDPOINT_LISTS];
    }

    public function getRequest() {

    }
}