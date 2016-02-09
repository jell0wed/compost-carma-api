<?php namespace CarmaAPI\endpoints;

use CarmaAPI\constants\CarmaAPIConstants;

class TriggersEndpoint extends APIEndpoint {
    public function __construct(\CarmaAPI\CarmaAPI $_api)
    {
        parent::__construct($_api, "/triggers");
    }

    public function getAll($_project_id = null, $_basic = CarmaAPIConstants::TRIGGERS_LIST_INCLUDE_BASIC_DATA) {
        $endpoint = "?basic={$_basic}" . (!is_null($_project_id) ? "&project_id={$_project_id}" : "");
        $resp = $this->api->getRequest($this->getUri($endpoint))->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\TriggerDto')->getArrayCopy();
    }

    /**
     * @param $_trigger_id
     * @return TriggerEndpoint
     */
    public function getById($_trigger_id) {
        return new TriggerEndpoint($this->api, $_trigger_id);
    }
}