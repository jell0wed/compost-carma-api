<?php namespace CarmaAPI\models;

use CarmaAPI\utils\CarmaAPIUtils;

class MessageDto {
    const PARAM_MESSAGES_URLS_DO_GENERATE_STATS = "true";
    const PARAM_MESSAGES_URLS_DONT_GENERATE_STATS = "false";

    const PARAM_MESSAGES_NO_OF_MESSAGES = 0;

    // TODO : PARAM_MESSAGES_START

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

    public static function generateQueryParams($_params) {
        $no_stats = CarmaAPIUtils::extractParameter($_params, "nostat", self::PARAM_MESSAGES_URLS_DO_GENERATE_STATS);
        $no_of_messages = CarmaAPIUtils::extractParameter($_params, "noOfMessages", self::PARAM_MESSAGES_NO_OF_MESSAGES);

        return "?nostat={$no_stats}&noOfMessages={$no_of_messages}";
    }
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
