<?php namespace CarmaAPI\constants;

abstract class CarmaAPIConstants {
    const LISTS_TYPE_NORMAL = 1;
    const LISTS_TYPE_TEST = 2;

    const CONTACTS_PREFERRED_CONTENT_HTML_TEXT = 0;
    const CONTACTS_PREFERRED_CONTENT_TEXT = 1;

    const CONTACTS_LIST_ITERATOR_ALL = "all";
    const CONTACTS_LIST_ITERATOR_BOUNCED = "bounced";
    const CONTACTS_LIST_ITERATOR_UNSUBSCRIBED = "unsubscribed";

    const CONTACT_MESSAGES_URL_GENERATES_STATS = "true";
    const CONTACT_MESSAGES_URL_DONT_GENERATES_STATS = "false";

    const TRIGGERS_LIST_INCLUDE_BASIC_DATA = "true";
    const TRIGGERS_LIST_DONT_INCLUDE_BASIC_DATA = "false";
}