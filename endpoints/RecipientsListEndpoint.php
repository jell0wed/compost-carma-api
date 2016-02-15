<?php namespace CarmaAPI\endpoints;

use CarmaAPI\CarmaAPI;
use CarmaAPI\constants\CarmaAPIConstants;
use CarmaAPI\models\ListDto;
use CarmaAPI\utils\CarmaAPIUtils;

class RecipientsListEndpoint extends APIEndpoint {
    const PARAM_NAME_TYPE_ID = "typeId";
    const PARAM_TYPE_ID_NORMAL_LISTS = 1;
    const PARAM_TYPE_ID_TEST_LISTS = 2;

    private $base_url;

    public function __construct($_api)
    {
        parent::__construct($_api);

        $this->base_url = $this->api->createUrl(CarmaAPI::ENDPOINT_LISTS);
    }

    /**
     * @return ListDto[]
     */
    public function getAll($_params = array()) {
        $url = $this->base_url;
        $url->addQuery(self::PARAM_NAME_TYPE_ID, CarmaAPIUtils::extractParameter($_params, self::PARAM_NAME_TYPE_ID, self::PARAM_TYPE_ID_NORMAL_LISTS));

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\ListDto')->getArrayCopy();
    }

    public function getById($_id) {
        return new RecipientListEndpoint($this->api, $_id);
    }
}