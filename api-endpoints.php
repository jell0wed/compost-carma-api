<?php namespace CarmaAPI\endpoints;

abstract class APIEndpoint {
    protected $uri;
    protected $api;

    protected function __construct($_api, $_endpoint_uri)
    {
        $this->api = $_api;
        $this->url = $_endpoint_uri;
    }
}