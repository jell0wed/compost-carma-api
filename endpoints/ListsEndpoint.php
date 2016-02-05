<?php namespace CarmaAPI\endpoints;

class ListsEndpoint extends APIEndpoint {
    public function __construct($_api)
    {
        parent::__construct($_api, "/lists");
    }

    public function get($_list_id) {
        return new ListEndpoint($this->api, $_list_id);
    }

    public function create() {

    }
}