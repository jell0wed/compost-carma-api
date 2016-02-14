<?php

use CarmaAPI\config\RESTAPIConfig;
use CarmaAPI\urls\CarmaAPIUrl;

include("includes/bootstrap.php");
$creds = explode("|", file_get_contents("./credentials.txt"));
$cfg = new RESTAPIConfig($creds[3], $creds[2]);
$cfg->setAuthentification(new CarmaAPI\config\auth\RESTBasicAPIAuthentification($creds[0], $creds[1]));
$api = new \CarmaAPI\CarmaAPI($cfg);

//var_dump($api->lists()->getById(14242)->contacts()->get(true, 100, 10000000));

/*foreach($api->lists()->getById(14242)->contacts()->iterator() as $contact) {
    $contact = $api->lists()->getById(14242)->contacts()->getByOriginalId($contact->originalId);
    echo $contact->get()->emailAddress . " - " . $contact->subscriptionStatus()->status . "\n";

    var_dump($contact->messages(100));
}*/

//var_dump($api->triggers()->getById(3422)->messages());

//var_dump(parse_url("http://google.ca?test=t&test2=33"));
