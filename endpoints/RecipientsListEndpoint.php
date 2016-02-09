<?php namespace CarmaAPI\endpoints;

use CarmaAPI\constants\CarmaAPIConstants;
use CarmaAPI\models\ListDto;

class RecipientsListEndpoint extends APIEndpoint {
    const LIST_TYPE_NORMAL = 1;
    const LIST_TYPE_TEST = 2;

    public function __construct($_api)
    {
        parent::__construct($_api, "/lists");
    }

    /**
     * @return ListDto[]
     */
    public function getAll($_params = array()) {
        $endpoint = "/" . ListDto::generateQueryParams($_params);
        $resp = $this->api->getRequest($this->getUri($endpoint))->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\ListDto')->getArrayCopy();
    }

    public function getById($_id) {
        return new RecipientListEndpoint($this->api, $_id);
    }
}