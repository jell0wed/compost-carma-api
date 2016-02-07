<?php namespace CarmaAPI\endpoints;

use CarmaAPI\constants\CarmaAPIConstants;
use CarmaAPI\models\BounceStatusDto;
use CarmaAPI\models\ContactDto;
use CarmaAPI\models\SubscriptionStatusDto;

class ContactEndpoint extends APIEndpoint {
    private $list_endpoint;
    private $original_id;

    public function __construct(\CarmaAPI\CarmaAPI $_api, ContactsListEndpoint $_list_endpoint, $_original_id)
    {
        parent::__construct($_api, "/lists/{$_list_endpoint->getListId()}/contacts/$_original_id");
    }

    /**
     * @return ContactDto
     */
    public function get() {
        $resp = $this->api->getRequest($this->getUri(""))->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->map($resp->body, new ContactDto());
    }

    /**
     * @return BounceStatusDto
     */
    public function bounceStatus() {
        $resp = $this->api->getRequest($this->getUri("/bouncestatus"))->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->map($resp->body, new BounceStatusDto());
    }

    /**
     * @return SubscriptionStatusDto
     */
    public function subscriptionStatus() {
        $resp = $this->api->getRequest($this->getUri("/subscriptionstatus"))->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->map($resp->body, new SubscriptionStatusDto());
    }

    // TODO : implement start date
    public function messages($_no_of_messages, $_no_stats = CarmaAPIConstants::CONTACT_MESSAGES_URL_GENERATES_STATS) {
        $resp = $this->api->getRequest($this->getUri("/messages?nostat={$_no_stats}&noOfMessages={$_no_of_messages}"))->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\MessageDto');
    }

}