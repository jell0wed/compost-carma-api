<?php

use CarmaAPI\config\RESTAPIConfig;

include("includes/bootstrap.php");
$creds = explode("|", file_get_contents("./credentials.txt"));
$cfg = new RESTAPIConfig($creds[3], $creds[2]);
$cfg->setAuthentification(new CarmaAPI\config\auth\RESTBasicAPIAuthentification($creds[0], $creds[1]));
$api = new \CarmaAPI\CarmaAPI($cfg);

var_dump($api->lists()->getById(14242)->contacts()->get(true, -1, 100));

//foreach($api->lists()->getById(14242)->contacts()->iterator() as $contact) {
//    echo $contact->fullName;
//}