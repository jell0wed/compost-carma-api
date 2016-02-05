<?php namespace CarmaAPI\endpoints;

use CarmaAPI\CarmaAPI;

abstract class APIEndpoint {
    protected $uri;
    protected $api;

    protected function __construct(CarmaAPI $_api, $_endpoint_uri)
    {
        $this->api = $_api;
        $this->url = $_endpoint_uri;

        $this->api->allocateEndpoint($this);
    }
}