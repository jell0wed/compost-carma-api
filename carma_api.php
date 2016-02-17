<?php namespace CarmaAPI;

require_once(dirname(__FILE__) . "/carma_endpoints.php");
require_once(dirname(__FILE__) . "/carma_urls.php");

use CarmaAPI\config\APIConfig;
use CarmaAPI\endpoints;
use CarmaAPI\urls\CarmaAPIUrl;

class CarmaAPI {
    const ENDPOINT_LISTS = "lists";
    const ENDPOINT_TRIGGERS = "triggers";
    const ENDPOINT_PROPERTIES = "properties";

    /**
     * @var APIConfig
     */
    private $config;

    private $loaded_endpoints = array();
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
        $this->loaded_endpoints[self::ENDPOINT_PROPERTIES] = new endpoints\PropertiesEndpoint($this);
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
    public function getRequest(CarmaAPIUrl $_api_url = null) {
        $concrete_url = $_api_url->stringify();
        $get = \Httpful\Request::get($concrete_url)
                ->addHeaders($this->config->getHeaders());

        $get = $this->config->getAuthentification()->performAuthentification($get);
        return $get;
    }

    /**
     * @param $_initial_path
     * @return CarmaAPIUrl
     */
    public function createUrl($_initial_path) {
        return CarmaAPIUrl::createInstance($this->config->getBaseAPIUrl(), $_initial_path);
    }
}