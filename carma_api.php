<?php namespace CarmaAPI;

define("ENDPOINT_LISTS", "lists");

require_once(dirname(__FILE__) . "/carma_endpoints.php");
require_once(dirname(__FILE__) . "/endpoints/RecipientsListEndpoint.php");
require_once(dirname(__FILE__) . "/endpoints/RecipientListEndpoint.php");
require_once(dirname(__FILE__) . "/endpoints/ContactsListEndpoint.php");
require_once(dirname(__FILE__) . "/endpoints/ContactEndpoint.php");

use CarmaAPI\config\APIConfig;
use CarmaAPI\endpoints;

class CarmaAPI {
    /**
     * @var APIConfig
     */
    private $config;

    private $loaded_endpoints = array();
    private $dynamic_endpoints = array();
    private $mapper;

    public function __construct(APIConfig $_conf)
    {
        $this->config = $_conf;
        $this->mapper = new \JsonMapper();
        $this->initializeStaticEndpoints();
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
        $this->loaded_endpoints[ENDPOINT_LISTS] = new endpoints\RecipientsListEndpoint($this);
    }

    /**
     * @return \JsonMapper
     */
    public function getMapper() {
        return $this->mapper;
    }

    /**
     * @return endpoints\RecipientsListEndpoint
     */
    public function lists() {
        return $this->loaded_endpoints[ENDPOINT_LISTS];
    }

    /**
     * @param $_endpoint_uri string
     * @return \Httpful\Request
     */
    public function getRequest($_endpoint_uri) {
        $get = \Httpful\Request::get($this->config->getAPIEndpointUrl($_endpoint_uri))
                ->addHeaders($this->config->getHeaders());

        $get = $this->config->getAuthentification()->performAuthentification($get);
        return $get;
    }
}