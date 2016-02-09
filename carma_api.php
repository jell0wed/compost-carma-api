<?php namespace CarmaAPI;


require_once(dirname(__FILE__) . "/carma_endpoints.php");

require_once(dirname(__FILE__) . "/endpoints/RecipientsListEndpoint.php");
require_once(dirname(__FILE__) . "/endpoints/RecipientListEndpoint.php");
require_once(dirname(__FILE__) . "/endpoints/ContactsListEndpoint.php");
require_once(dirname(__FILE__) . "/endpoints/ContactEndpoint.php");

require_once(dirname(__FILE__) . "/endpoints/TriggersEndpoint.php");
require_once(dirname(__FILE__) . "/endpoints/TriggerEndpoint.php");

use CarmaAPI\config\APIConfig;
use CarmaAPI\endpoints;

class CarmaAPI {
    const ENDPOINT_LISTS = "lists";
    const ENDPOINT_TRIGGERS = "triggers";
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
        $this->loaded_endpoints[self::ENDPOINT_LISTS] = new endpoints\RecipientsListEndpoint($this);
        $this->loaded_endpoints[self::ENDPOINT_TRIGGERS] = new endpoints\TriggersEndpoint($this);
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
        return $this->loaded_endpoints[self::ENDPOINT_LISTS];
    }

    /**
     * @return endpoints\TriggersEndpoint
     */
    public function triggers() {
        return $this->loaded_endpoints[self::ENDPOINT_TRIGGERS];
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