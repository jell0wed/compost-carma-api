<?php namespace CarmaAPI\endpoints;

use CarmaAPI\CarmaAPI;
use CarmaAPI\models\MessageDto;
use CarmaAPI\models\TriggerDto;
use CarmaAPI\utils\CarmaAPIUtils;

class TriggerEndpoint extends APIEndpoint {
    private $trigger_id;
    private $base_url;

    public function __construct(\CarmaAPI\CarmaAPI $_api, $_trigger_id)
    {
        parent::__construct($_api);

        $this->trigger_id = $_trigger_id;
        $this->base_url = $this->api->createUrl(CarmaAPI::ENDPOINT_TRIGGERS)
                                    ->addPath($this->trigger_id);
    }

    public function get() {
        $url = $this->base_url;

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->map($resp->body, new TriggerDto());
    }

    const PARAM_NAME_NO_STAT = "nostat";
    const PARAM_NO_STAT_TRUE = "true";
    const PARAM_NO_STAT_FALSE = "false";

    const PARAM_NAME_NO_OF_MESSAGES = "noOfMessages";
    const PARAM_NO_OF_MESSAGES_DEFAULT = 100;

    // TODO : start time parameter
    public function messages($_params = array()) {
        $url = $this->base_url;
        $url->addQuery(self::PARAM_NAME_NO_STAT, CarmaAPIUtils::extractParameter($_params, self::PARAM_NAME_NO_STAT, self::PARAM_NO_STAT_FALSE))
            ->addQuery(self::PARAM_NAME_NO_OF_MESSAGES, CarmaAPIUtils::extractParameter($_params, self::PARAM_NAME_NO_OF_MESSAGES, self::PARAM_NO_OF_MESSAGES_DEFAULT));

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\MessageDto')->getArrayCopy();
    }

    public function campaigns() {
        $url = $this->base_url;
        $url->addPath("campaigns");

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\CampaignVersionDto')->getArrayCopy();
    }

    public function links() {
        $url = $this->base_url;
        $url->addPath("links");

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\LinkDto')->getArrayCopy();
    }

    public function tags() {
        $url = $this->base_url;
        $url->addPath("tags");

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\BlockLinkTagDto')->getArrayCopy();
    }
}