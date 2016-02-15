<?php

use CarmaAPI\config\RESTAPIConfig;
use CarmaAPI\urls\CarmaAPIUrl;

include("includes/bootstrap.php");
$creds = explode("|", file_get_contents("./credentials.txt"));
$cfg = new RESTAPIConfig($creds[3], $creds[2]);
$cfg->setAuthentification(new CarmaAPI\config\auth\RESTBasicAPIAuthentification($creds[0], $creds[1]));
$api = new \CarmaAPI\CarmaAPI($cfg);

//var_dump($api->lists()->getAll());

//var_dump($api->lists()->getById(14242)->contacts()->getAll(\CarmaAPI\endpoints\ContactsListEndpoint::LIST_MODE_ALL));

$c = 0;
foreach($api->lists()->getById(14242)->contacts()->iterator() as $contact) {
    $contact = $api->lists()->getById(14242)->contacts()->getByOriginalId($contact->originalId);

    echo $contact->get()->emailAddress . " - " . $contact->subscriptionStatus()->status . "\n";
}

//var_dump($api->triggers()->getById(3422)->messages());

