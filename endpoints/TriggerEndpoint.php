<?php namespace CarmaAPI\endpoints;

use CarmaAPI\models\MessageDto;

class TriggerEndpoint extends APIEndpoint {
    private $trigger_id;

    public function __construct(\CarmaAPI\CarmaAPI $_api, $_trigger_id)
    {
        $this->trigger_id = $_trigger_id;
        parent::__construct($_api, "/triggers/{$_trigger_id}");
    }

    public function messages($_params = array()) {
        $endpoint = "/messages" . MessageDto::generateQueryParams($_params);
        $resp = $this->api->getRequest($this->getUri($endpoint))->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\MessageDto')->getArrayCopy();
    }
}