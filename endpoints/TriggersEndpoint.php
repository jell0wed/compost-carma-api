<?php namespace CarmaAPI\endpoints;

use CarmaAPI\CarmaAPI;
use CarmaAPI\constants\CarmaAPIConstants;
use CarmaAPI\models\TriggerDto;
use CarmaAPI\utils\CarmaAPIUtils;

class TriggersEndpoint extends APIEndpoint {
    private $base_url;

    public function __construct(\CarmaAPI\CarmaAPI $_api)
    {
        parent::__construct($_api);
        $this->base_url = $this->api->createUrl(CarmaAPI::ENDPOINT_TRIGGERS);
    }

    const PARAM_NAME_PROJECT_ID = "projectId";

    const PARAM_NAME_BASIC = "basic";
    const PARAM_BASIC_INCLUDE_DATA = "true";
    const PARAM_BASIC_DONT_INCLUDE_DATA = "false";

    public function getAll($_params = array()) {
        $url = $this->base_url;
        $url->addQuery(self::PARAM_NAME_PROJECT_ID, CarmaAPIUtils::extractParameter($_params, self::PARAM_NAME_PROJECT_ID))
            ->addQuery(self::PARAM_NAME_BASIC, CarmaAPIUtils::extractParameter($_params, self::PARAM_NAME_BASIC, self::PARAM_BASIC_INCLUDE_DATA));

        $resp = $this->api->getRequest($url)->send();
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