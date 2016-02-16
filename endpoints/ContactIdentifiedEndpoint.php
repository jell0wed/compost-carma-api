<?php namespace CarmaAPI\endpoints;

use CarmaAPI\CarmaAPI;
use CarmaAPI\models\BounceDto;
use CarmaAPI\models\BounceStatusDto;
use CarmaAPI\models\ContactDto;
use CarmaAPI\models\MessageCountDto;
use CarmaAPI\models\SubscriptionStatusDto;
use CarmaAPI\urls\CarmaAPIUrl;

abstract class ContactIdentifiedEndpoint extends APIEndpoint {
    protected $list_endpoint;
    /**
     * @var CarmaAPIUrl
     */
    protected $base_url;

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

    public abstract function lastBounce();

    const PARAM_MESSAGE_COUNT_TYPE_EMAIL = "email";
    const PARAM_MESSAGE_COUNT_TYPE_SMS = "sms";

    public abstract function messageCount($_type = self::PARAM_MESSAGE_COUNT_TYPE_EMAIL);

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

    public function lastBounce()
    {
        $url = $this->base_url;
        $url->addPath("lastbounce");

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->map($resp->body, new BounceDto());
    }

    public function messageCount($_type = ContactIdentifiedEndpoint::PARAM_MESSAGE_COUNT_TYPE_EMAIL)
    {
        $url = $this->base_url;
        $url->addPath("messagecount")
            ->addPath($_type);

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->map($resp->body, new MessageCountDto());
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

    private function getListIdentifiedEquivalentEndpoint() {
        try {
            $contact = $this->get();
            return new ContactIdentifiedByIdEndpoint($this->api, $this->list_endpoint, $contact->id);
        } catch (\Exception $e) {
            // TODO : Throw exception; unable to get contact list identifier
            throw $e;
        }
    }

    public function lastBounce()
    {
        return $this->getListIdentifiedEquivalentEndpoint()->lastBounce();
    }

    public function messageCount($_type = ContactIdentifiedEndpoint::PARAM_MESSAGE_COUNT_TYPE_EMAIL)
    {
        return $this->getListIdentifiedEquivalentEndpoint()->messageCount($_type);
    }
}