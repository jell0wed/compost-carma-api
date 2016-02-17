<?php namespace CarmaAPI\endpoints;

require_once(dirname(__FILE__) . "/endpoints/RecipientsListEndpoint.php");
require_once(dirname(__FILE__) . "/endpoints/RecipientListEndpoint.php");
require_once(dirname(__FILE__) . "/endpoints/ContactsListEndpoint.php");
require_once(dirname(__FILE__) . "/endpoints/ContactIdentifiedEndpoint.php");


require_once(dirname(__FILE__) . "/endpoints/TriggersEndpoint.php");
require_once(dirname(__FILE__) . "/endpoints/TriggerEndpoint.php");

require_once(dirname(__FILE__) . "/endpoints/PropertiesEndpoint.php");

use CarmaAPI\CarmaAPI;
use CarmaAPI\urls\CarmaAPIUrl;

abstract class APIEndpoint {
    protected $api;

    protected function __construct(CarmaAPI $_api)
    {
        $this->api = $_api;

        $this->api->allocateEndpoint($this);
    }

    protected function handleResponseErrorIfAny(\Httpful\Response $resp) {
        // TODO : check http code, throw exception; proper exception handling
    }
}