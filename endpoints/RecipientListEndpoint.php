<?php namespace CarmaAPI\endpoints;

use CarmaAPI\models\ListDto;
use CarmaAPI\models\UnsubscribeUrlDto;

class RecipientListEndpoint extends APIEndpoint {
    private $list_id;

    public function __construct($_api, $_list_id)
    {
        $this->list_id = $_list_id;
        parent::__construct($_api, "/lists/" . $this->list_id);
    }

    public function get() {
        $resp = $this->api->getRequest($this->getUri(""))->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->map($resp->body, new ListDto());
    }

    public function unsubscribeUrl() {
        $resp = $this->api->getRequest($this->getUri("/unsubscribeurl"))->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->map($resp->body, new UnsubscribeUrlDto());
    }

    public function contacts() {
        return new ContactsListEndpoint($this->api, $this, $this->list_id);
    }

    public function messages() {
        $resp = $this->api->getRequest($this->getUri("/messages"))->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\MessageDto')->getArrayCopy();
    }
}