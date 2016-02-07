<?php namespace CarmaAPI\models;

class MessageDto {
    public $id;

    public $contactId;

    public $deliveryId;

    public $read;

    public $readTimestamp;

    public $sentTimestamp;

    public $openInBrowserUrl;

    /**
     * @var MessageActions
     */
    public $actions;

    public $type;

    public $module;

    public $name;

    public $archived;
}

class MessageActions {
    public $opened;

    public $recieved;

    public $clicked;

    public $converted;

    public $softBounce;

    public $hardBounce;

    public $unsubscribed;

    public $complaint;
}
