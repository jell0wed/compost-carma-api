<?php namespace CarmaAPI\models;

use CarmaAPI\utils\CarmaAPIUtils;

class TriggerDto {
    const PARAM_TRIGGERS_LIST_DONT_INCLUDE_BASIC_DATA = "false";
    const PARAM_TRIGGERS_LIST_INCLUDE_BASIC_DATA = "true";

    public $id;

    public $type;

    public $projectId;

    public $name;

    public $description;

    public $listId;

    public $dateCreated;

    public $dateModified;

    public $userCreated;

    public $userModified;

    public $channelTypeId;

    public $activeCampaign;

    public $ignoreOptOut;

    public $campaignVersions;

    public $active;

    public static function generateQueryParams($_params = array()) {
        $projectId = CarmaAPIUtils::extractParameter($_params, "projectId");
        $basic = CarmaAPIUtils::extractParameter($_params, "basic", self::PARAM_TRIGGERS_LIST_INCLUDE_BASIC_DATA);

        return "?basic={$basic}";
    }
}