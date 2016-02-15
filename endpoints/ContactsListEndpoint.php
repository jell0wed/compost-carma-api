<?php
namespace CarmaAPI\endpoints;
use CarmaAPI\CarmaAPI;
use CarmaAPI\utils\CarmaAPIUtils;
use CarmaAPI\models\ContactDto;

class ContactsListEndpoint extends APIEndpoint {
    private $list_id;
    private $recipients_list_endpoint = null;
    private $base_url;

    public function __construct(\CarmaAPI\CarmaAPI $_api, RecipientListEndpoint $_rcpt_list_endpoint, $_list_id)
    {
        parent::__construct($_api);

        $this->recipients_list_endpoint = $_rcpt_list_endpoint;
        $this->list_id = $_list_id;
        $this->base_url = $this->api->createUrl(CarmaAPI::ENDPOINT_LISTS)
                                    ->addPath($this->list_id)
                                    ->addPath("contacts");
    }

    public function getListId() { return $this->list_id; }

    const LIST_MODE_ALL = "all";
    const LIST_MODE_BOUNCED = "bounced";
    const LIST_MODE_UNSUBSCRIBED = "unsubscribed";

    const PARAM_NAME_EMAIL = "email";

    const PARAM_NAME_PAGE_SIZE = "pageSize";
    const PARAM_PAGE_SIZE_DEFAULT = 1000;

    const PARAM_NAME_CHANNEL = "channel";
    const PARAM_CHANNEL_MIXED = "MIXED";

    const PARAM_NAME_LAST_ID = "lastId";
    const PARAM_LAST_ID_DEFAULT = -1;

    const PARAM_NAME_INCLUDE_PROPERTIES = "includeProperties";
    const PARAM_DO_INCLUDE_PROPERTIES = "true";
    const PARAM_DONT_INCLUDE_PROPERTIES = "false";

    public function getAll($_mode = self::LIST_MODE_ALL, $_params = array()) {
        $url = $this->base_url;
        $url->addPath($_mode)
            ->addQuery(self::PARAM_NAME_EMAIL, CarmaAPIUtils::extractParameter($_params, self::PARAM_NAME_EMAIL))
            ->addQuery(self::PARAM_NAME_PAGE_SIZE, CarmaAPIUtils::extractParameter($_params, self::PARAM_NAME_PAGE_SIZE, self::PARAM_PAGE_SIZE_DEFAULT))
            ->addQuery(self::PARAM_NAME_CHANNEL, CarmaAPIUtils::extractParameter($_params, self::PARAM_NAME_CHANNEL, self::PARAM_CHANNEL_MIXED))
            ->addQuery(self::PARAM_NAME_LAST_ID, CarmaAPIUtils::extractParameter($_params, self::PARAM_NAME_LAST_ID, self::PARAM_LAST_ID_DEFAULT))
            ->addQuery(self::PARAM_NAME_INCLUDE_PROPERTIES, CarmaAPIUtils::extractParameter($_params, self::PARAM_NAME_INCLUDE_PROPERTIES, self::PARAM_DO_INCLUDE_PROPERTIES));

        $resp = $this->api->getRequest($url)->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\ContactDto')->getArrayCopy();
    }

    public function iterator($_mode = self::LIST_MODE_ALL, $_params = array()) {
        return new ContactListIterator($this, $_mode, $_params);
    }

    public function getByOriginalId($original_id) {
        return new ContactIdEndpoint($this->api, $this, $original_id);
    }

}



class ContactListIterator implements \Iterator {
    private $currentListEndpoint = null;
    /**
     * @var ContactDto[]
     */
    private $params = array();
    private $mode = ContactsListEndpoint::LIST_MODE_ALL;

    private $currentList = array();
    private $currIndex = 0;
    private $listPageSize = 0;

    public function __construct(ContactsListEndpoint $_endpoint, $_mode, $_params)
    {
        $this->mode = $_mode;
        $this->params = $_params;
        $this->currentListEndpoint = $_endpoint;
        $this->listPageSize = CarmaAPIUtils::extractParameter($_params, ContactsListEndpoint::PARAM_NAME_PAGE_SIZE, ContactsListEndpoint::PARAM_PAGE_SIZE_DEFAULT);
    }

    private function needToReload() {
        return $this->currIndex >= $this->listPageSize || $this->currIndex == -1;
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->currentList[$this->currIndex];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->currIndex++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->currIndex;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        if($this->needToReload()) {
            $last_id = 0;
            if(count($this->currentList) > 0) {
                $last_id = array_pop($this->currentList)->id;
            }

            unset($this->currentList);

            $params = $this->params;
            $params["lastId"] = $last_id;

            $this->currentList = $this->currentListEndpoint->getAll($this->mode, $params);

            if($this->currIndex == -1) {
                $this->currIndex = 0;
            }
        }

        return !is_null($this->current());
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->currIndex = -1;
    }
}


