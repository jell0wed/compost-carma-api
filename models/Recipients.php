<?php namespace CarmaAPI\models;

class Permissions {
    public $read;

    public $write;

    public $execute;
}

class BreakDownDetails {
    public $bounced;

    public $unsubscribed;

    public $contacts;
}

class ListBreakDown {
    /**
     * @var BreakDownDetails
     */
    public $email;

    /**
     * @var BreakDownDetails
     */
    public $mobile;

    /**
     * @var BreakDownDetails
     */
    public $android;

    /**
     * @var BreakDownDetails
     */
    public $ios;

    /**
     * @var BreakDownDetails
     */
    public $qq;

    /**
     * @var BreakDownDetails
     */
    public $postal;

    /**
     * @var BreakDownDetails
     */
    public $windowsPush;
}

class ListDto {
    /**
     * @var Permissions
     */
    public $permissions;

    /**
     * @var ListBreakDown
     */
    public $breakdown;

    public $id;

    public $listTypeId;

    public $name;

    public $description;

    public $lastImportTime;

    public $lastUpdateTime;

    public $generateUpToDateOnly;

    public $complaints;

    public $unsubscribes;

    public $hardBounces;

    public $contacts;

    public $inactive;

    public $emailAddresses;

    public $mobileNumbers;

    public $pushIds;
}