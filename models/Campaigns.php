<?php namespace CarmaAPI\models;

class CampaignVersionDto {
    public $campaignId;

    public $campaignName;

    public $campaignTypeId;

    public $active;

    public $locked;

    public $dateCreated;

    public $dateModified;

    public $userCreated;

    public $userModified;

    /***
     * @var RealTimeStatDto
     */
    public $statusDtos;

    public $lastActivated;
}

class RealTimeStatDto {
    public $id;

    public $deliveryId;

    public $source;

    public $projectId;

    public $deliveryTypeId;

    public $recipients;

    public $sent;

    public $opened;

    public $clicked;

    public $openedInBrower;

    public $unsubscribed;

    public $notBounced;

    public $softBounced;

    public $hardBounced;

    public $complaints;

    public $shareTarget;

    public $mailClick;

    public $conversions;

    public $uniqueClick;

    public $amount;
}