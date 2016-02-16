<?php namespace CarmaAPI\models;

class BounceDto {
    public $messageId;

    public $bounceType;

    public $recipient;

    public $mta;

    public $vmta;

    public $bncCat;

    public $dsnStatus;

    public $dsnMta;

    public $dsnDiagnosis;

    public $dsnStatusCode;

    public $senderAddress;

    public $bounceDate;

    public $domain;

    public $remoteMta;
}