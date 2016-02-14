<?php namespace CarmaAPI\endpoints;

use CarmaAPI\CarmaAPI;
use CarmaAPI\constants\CarmaAPIConstants;
use CarmaAPI\models\BounceStatusDto;
use CarmaAPI\models\ContactDto;
use CarmaAPI\models\MessageDto;
use CarmaAPI\models\SubscriptionStatusDto;
use CarmaAPI\urls\CarmaAPIUrl;
use CarmaAPI\urls\ContactBounceStatusUrl;
use CarmaAPI\urls\ContactByIdUrl;
use CarmaAPI\urls\ContactByOriginalIdUrl;
use CarmaAPI\urls\ContactsListUrl;

class ContactIdEndpoint extends APIEndpoint {
    private $list_endpoint;
    private $identifier;
    private $base_url;

    public function __construct(\CarmaAPI\CarmaAPI $_api, ContactsListEndpoint $_list_endpoint, $_id)
    {
        $this->identifier = $_id;
        $this->list_endpoint = $_list_endpoint;
        parent::__construct($_api);
    }

    /**
     * @return ContactDto
     */
    public function get() {
        $url = $this->api->createUrl(CarmaAPI::ENDPOINT_LISTS)->applyPathParameter(
            function (\Purl\Path $_current_path) {
                return $_current_path
                    ->add($this->list_endpoint->getListId())
                    ->add("contacts")
                    ->add($this->identifier);
            });

        $resp = $this->api->getRequest($url->stringify())->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->map($resp->body, new ContactDto());
    }

    /**
     * @return BounceStatusDto
     */
    public function bounceStatus() {
        $url = $this->api->createUrl(CarmaAPI::ENDPOINT_LISTS)->applyPathParameter(
            function (\Purl\Path $_current_path) {
                return $_current_path
                    ->add($this->list_endpoint->getListId())
                    ->add("contacts")
                    ->add($this->identifier);
            }
        );

        $resp = $this->api->getRequest($url->stringify())->send();
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
    public function messages($_params = array()) {
        $endpoint = "/messages" . MessageDto::generateQueryParams($_params);
        $resp = $this->api->getRequest($this->getUri($endpoint))->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\MessageDto')->getArrayCopy();
    }

}