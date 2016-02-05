<?php

use CarmaAPI\config\RESTAPIConfig;

include("includes/bootstrap.php");
$creds = explode("|", file_get_contents("./credentials.txt"));
$cfg = new RESTAPIConfig($creds[3], $creds[2]);
$cfg->setAuthentification(new CarmaAPI\config\auth\RESTBasicAPIAuthentification($creds[0], $creds[1]));
$api = new \CarmaAPI\CarmaAPI($cfg);

var_dump(count($api->lists()->get()));