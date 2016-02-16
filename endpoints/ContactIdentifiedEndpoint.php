<?php namespace CarmaAPI\endpoints;

use CarmaAPI\CarmaAPI;
use CarmaAPI\models\BounceStatusDto;
use CarmaAPI\models\ContactDto;
use CarmaAPI\models\SubscriptionStatusDto;

abstract class ContactIdentifiedEndpoint extends APIEndpoint {
    private $list_endpoint;
    private $base_url;

    public function __construct(\CarmaAPI\CarmaAPI $_api, ContactsListEndpoint $_list_endpoint)
    {
        parent::__construct($_api);

        $this->list_endpoint = $_list_endpoint;
        $this->base_url = $this->api->createUrl(CarmaAPI::ENDPOINT_LISTS)
                                    ->addPath($this->list_endpoint->getListId())
                                    ->addPath("contacts")
                                    ->addPath($this->getIdentifier());
    }

    protected abstract function getIdentifier();

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

class ContactIdentifiedByIdEndpoint extends ContactIdentifiedEndpoint {
    private $identifier;
    public function __construct(CarmaAPI $_api, ContactsListEndpoint $_list_endpoint, $_identifier)
    {
        parent::__construct($_api, $_list_endpoint);
        $this->identifier = $_identifier;
    }

    protected function getIdentifier()
    {
        return $this->identifier;
    }
}

class ContactIdentifiedByOriginalIdEndpoint extends ContactIdentifiedEndpoint {
    private $original_id;

    public function __construct(CarmaAPI $_api, ContactsListEndpoint $_list_endpoint, $_original_id)
    {
        parent::__construct($_api, $_list_endpoint);
        $this->original_id = $_original_id;
    }

    protected function getIdentifier()
    {
        return $this->original_id;
    }
}