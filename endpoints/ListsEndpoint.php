<?php namespace CarmaAPI\endpoints;

use CarmaAPI\models\ListDto;

class ListsEndpoint extends APIEndpoint {
    public function __construct($_api)
    {
        parent::__construct($_api, "/lists");
    }

    /**
     * @return ListDto[]
     */
    public function get() {
        $resp = $this->api->getRequest($this->getUri(""))->send();
        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\ListDto');
    }

    public function create() {

    }
}