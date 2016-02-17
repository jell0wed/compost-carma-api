<?php namespace CarmaAPI\endpoints;

use CarmaAPI\CarmaAPI;

class PropertiesEndpoint extends APIEndpoint {
    private $base_url;

    public function __construct(CarmaAPI $_api)
    {
        parent::__construct($_api);

        $this->base_url = $this->api->createUrl(CarmaAPI::ENDPOINT_PROPERTIES);
    }

    public function getAll() {
        $url = $this->base_url;

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\PropertyDto')->getArrayCopy();
    }

    public function zapier() {
        $url = $this->base_url;
        $url->addPath("zapier");

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\ZapierAttributeDto')->getArrayCopy();
    }
}