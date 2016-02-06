<?php namespace CarmaAPI\endpoints;

use CarmaAPI\models\ListDto;

class RecipientListEndpoint extends APIEndpoint {
    private $list_id;

    public function __construct($_api, $_list_id)
    {
        $this->list_id = $_list_id;
        parent::__construct($_api, "/lists/" . $this->list_id);
    }

    public function get() {
        $resp = $this->api->getRequest($this->getUri(""))->send();
        return $this->api->getMapper()->map($resp->body, new ListDto());
    }

    public function contacts() {
        return new ContactsListEndpoint($this->api, $this->list_id);
    }
}