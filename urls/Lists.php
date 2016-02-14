<?php namespace CarmaAPI\urls;

use CarmaAPI\utils\CarmaAPIUtils;

class RecipientsListsUrl extends CarmaAPIUrl {
    public function __construct()
    {
        parent::__construct("/lists", array());
    }
}

class RecipientListUrl extends CarmaAPIUrl {
    public function __construct($_list_id, $_params)
    {
        parent::__construct("/lists/{$_list_id}", $_params);
    }
}

class ContactsListUrl extends CarmaAPIUrl {
    const LIST_MODE_BOUNCED = "bounced";
    const LIST_MODE_ALL = "all";
    const LIST_MODE_UNSUBSCRIBED = "unsubscribed";

    const PARAM_CONTACTS_LIST_DEFAULT_INCLUDE_PROPERTIES = "true";
    const PARAM_CONTACTS_LIST_DEFAULT_LAST_ID = -1;

    const PARAM_CONTACTS_PREFERRED_CONTENT_TEXT = 1;
    const PARAM_CONTACTS_PREFERRED_CONTENT_HTML_TEXT = 0;

    const PARAM_NAME_EMAIL = "email";

    const PARAM_NAME_PAGESIZE = "pageSize";
    const PARAM_PAGESIZE_DEFAULT = 1000;

    const PARAM_NAME_CHANNEL = "channel";
    const PARAM_CHANNEL_DEFAULT = "mixed";

    const PARAM_NAME_LAST_ID = "lastId";
    const PARAM_LAST_ID_DEFAULT = -1;

    const PARAM_NAME_INCLUDE_PROPERTIES = "includeProperties";
    const PARAM_INCLUDE_PROPERTIES_DEFAULT = "true";

    public function __construct($_list_id, $_mode = self::LIST_MODE_ALL, $_params = array())
    {
        parent::__construct("/lists/{$_list_id}/{$_mode}/contacts", $_params);
    }

    /**
     * @return array()
     */
    protected function getQueryParameters()
    {
        return array(
            self::PARAM_NAME_EMAIL => CarmaAPIUtils::extractParameter($this->query_params, self::PARAM_NAME_EMAIL),
            self::PARAM_NAME_PAGESIZE => CarmaAPIUtils::extractParameter($this->query_params, self::PARAM_NAME_PAGESIZE, self::PARAM_PAGESIZE_DEFAULT),
            self::PARAM_NAME_CHANNEL => CarmaAPIUtils::extractParameter($this->query_params, self::PARAM_NAME_CHANNEL, self::PARAM_CHANNEL_DEFAULT),
            self::PARAM_NAME_LAST_ID => CarmaAPIUtils::extractParameter($this->query_params, self::PARAM_NAME_LAST_ID, self::PARAM_LAST_ID_DEFAULT),
            self::PARAM_NAME_INCLUDE_PROPERTIES => CarmaAPIUtils::extractParameter($this->query_params, self::PARAM_NAME_INCLUDE_PROPERTIES, self::PARAM_INCLUDE_PROPERTIES_DEFAULT)
        );
    }
}

