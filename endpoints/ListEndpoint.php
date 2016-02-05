<?php namespace CarmaAPI\endpoints;

class ListEndpoint extends APIEndpoint {
    private $list_id;
    public function __construct($_api, $_list_id)
    {
        $this->list_id = $_list_id;
        parent::__construct($_api, "lists/" . $this->list_id);
    }
}