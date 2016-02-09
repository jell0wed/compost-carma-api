<?php namespace CarmaAPI\models;

use CarmaAPI\utils\CarmaAPIUtils;

class ContactDto {
    const PARAM_CONTACTS_LIST_DEFAULT_PAGESIZE = "1000";
    const PARAM_CONTACTS_LIST_DEFAULT_CHANNEL = "mixed";
    const PARAM_CONTACTS_LIST_DEFAULT_LAST_ID = -1;
    const PARAM_CONTACTS_LIST_DEFAULT_INCLUDE_PROPERTIES = "true";

    const PARAM_CONTACTS_LIST_MODE_ALL = "all";
    const PARAM_CONTACTS_LIST_MODE_UNSUBSCRIBED = "unsubscribed";
    const PARAM_CONTACTS_LIST_MODE_BOUNCED = "bounced";

    const PARAM_CONTACTS_PREFERRED_CONTENT_HTML_TEXT = 0;
    const PARAM_CONTACTS_PREFERRED_CONTENT_TEXT = 1;

    public $id;

    public $listId;

    public $country;

    public $originalId;

    public $originalIdHashed;

    public $firstName;

    public $lastName;

    public $middleName;

    public $emailAddress;

    public $title;

    public $dateOfBirth;

    public $city;

    public $zipCode;

    public $sex;

    public $mobileNumber;

    public $unsubscribed;

    public $bounced;

    public $mobileBounced;

    public $preferredContentVersionId;

    public $optOutDate;

    public $dateOfInvalidation;

    public $optOutMobileDate;

    public $active;

    public $dateCreated;

    public $dateModified;

    /**
     * @var stdClass
     */
    public $properties;

    public static function generateQueryParams($_params) {
        $pageSize = CarmaAPIUtils::extractParameter($_params, "pageSize", self::PARAM_CONTACTS_LIST_DEFAULT_PAGESIZE);
        $channel = CarmaAPIUtils::extractParameter($_params, "channel", self::PARAM_CONTACTS_LIST_DEFAULT_CHANNEL);
        $lastId = CarmaAPIUtils::extractParameter($_params, "lastId", self::PARAM_CONTACTS_LIST_DEFAULT_LAST_ID);
        $includeProperties = CarmaAPIUtils::extractParameter($_params, "includeProperties", self::PARAM_CONTACTS_LIST_DEFAULT_INCLUDE_PROPERTIES);

        return "?pageSize={$pageSize}&channel={$channel}&lastId={$lastId}&includeProperties={$includeProperties}";
    }
}

class BounceStatusDto {
    public $status;
}

class SubscriptionStatusDto {
    public $status;

    public $mobileStatus;
}