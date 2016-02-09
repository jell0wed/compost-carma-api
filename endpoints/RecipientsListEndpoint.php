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
    public function getAll($_type = CarmaAPIConstants::LISTS_TYPE_NORMAL) {
        $resp = $this->api->getRequest($this->getUri("?typeId=" . $_type))->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\ListDto')->getArrayCopy();
    }

    public function getById($_id) {
        return new RecipientListEndpoint($this->api, $_id);
    }
}