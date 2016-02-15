<?php namespace CarmaAPI\endpoints;

use CarmaAPI\CarmaAPI;
use CarmaAPI\models\ListDto;
use CarmaAPI\models\UnsubscribeUrlDto;
use CarmaAPI\utils\CarmaAPIUtils;

class RecipientListEndpoint extends APIEndpoint {
    private $list_id;
    private $base_url;

    public function __construct($_api, $_list_id)
    {
        parent::__construct($_api);

        $this->list_id = $_list_id;
        $this->base_url = $this->api->createUrl(CarmaAPI::ENDPOINT_LISTS)
                                    ->addPath($this->list_id);
    }

    public function get() {
        $url = $this->base_url;

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->map($resp->body, new ListDto());
    }

    public function unsubscribeUrl() {
        $url = $this->base_url;
        $url->addPath("unsubscribeurl");

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->map($resp->body, new UnsubscribeUrlDto());
    }

    const PARAM_NAME_NO_STAT = "nostat";
    const PARAM_NO_STAT_TRUE = "true";
    const PARAM_NO_STAT_FALSE = "false";

    const PARAM_NAME_NO_OF_MESSAGES = "noOfMessages";
    const PARAM_NO_OF_MESSAGES = 100;

    // TODO : param start date
    public function messages($_params = array()) {
        $url = $this->base_url;
        $url->addPath("messages");
        $url->addQuery(self::PARAM_NAME_NO_STAT, CarmaAPIUtils::extractParameter($_params, self::PARAM_NAME_NO_STAT, self::PARAM_NO_STAT_FALSE))
            ->addQuery(self::PARAM_NAME_NO_OF_MESSAGES, CarmaAPIUtils::extractParameter($_params, self::PARAM_NAME_NO_OF_MESSAGES, self::PARAM_NO_OF_MESSAGES));

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\MessageDto')->getArrayCopy();
    }

    public function contacts() {
        return new ContactsListEndpoint($this->api, $this, $this->list_id);
    }

}