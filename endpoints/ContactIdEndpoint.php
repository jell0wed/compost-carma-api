<?php namespace CarmaAPI\endpoints;

use CarmaAPI\CarmaAPI;
use CarmaAPI\models\BounceStatusDto;
use CarmaAPI\models\ContactDto;
use CarmaAPI\models\SubscriptionStatusDto;

class ContactIdEndpoint extends APIEndpoint {
    private $list_endpoint;
    private $identifier;
    private $base_url;

    public function __construct(\CarmaAPI\CarmaAPI $_api, ContactsListEndpoint $_list_endpoint, $_id)
    {
        parent::__construct($_api);

        $this->identifier = $_id;
        $this->list_endpoint = $_list_endpoint;
        $this->base_url = $this->api->createUrl(CarmaAPI::ENDPOINT_LISTS)
                                    ->addPath($this->list_endpoint->getListId())
                                    ->addPath("contacts")
                                    ->addPath($this->identifier);
    }

    /**
     * @return ContactDto
     */
    public function get() {
        $url = $this->base_url;

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->map($resp->body, new ContactDto());
    }

    /**
     * @return BounceStatusDto
     */
    public function bounceStatus() {
        $url = $this->base_url;
        $url->addPath("bouncestatus");

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->map($resp->body, new BounceStatusDto());
    }

    /**
     * @return SubscriptionStatusDto
     */
    public function subscriptionStatus() {
        $url = $this->base_url;
        $url->addPath("subscriptionstatus");

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->map($resp->body, new SubscriptionStatusDto());
    }

    // TODO : implement start date
    public function messages($_params = array()) {
        $url = $this->base_url;
        $url->addPath("messages");

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\MessageDto')->getArrayCopy();
    }

}