<?php
namespace CarmaAPI\endpoints\iterators;
use CarmaAPI\constants\CarmaAPIConstants;
use CarmaAPI\endpoints\ContactsListEndpoint;
use CarmaAPI\models\ContactDto;
use CarmaAPI\utils\CarmaAPIUtils;

class ContactListIterator implements \Iterator {
    private $currentListEndpoint = null;
    /**
     * @var ContactDto[]
     */
    private $params = array();
    private $mode = ContactDto::PARAM_CONTACTS_LIST_MODE_ALL;

    private $currentList = array();
    private $currIndex = 0;
    private $listPageSize = 0;

    public function __construct(ContactsListEndpoint $_endpoint, $_mode, $_params)
    {
        $this->mode = $_mode;
        $this->params = $_params;
        $this->currentListEndpoint = $_endpoint;
        $this->listPageSize = CarmaAPIUtils::extractParameter($_params, "pageSize", ContactDto::PARAM_CONTACTS_LIST_DEFAULT_PAGESIZE);
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

namespace CarmaAPI\endpoints;
use CarmaAPI\constants\CarmaAPIConstants;
use CarmaAPI\endpoints\iterators\ContactListIterator;
use CarmaAPI\models\ContactDto;

class ContactsListEndpoint extends APIEndpoint {
    private $list_id;
    private $recipients_list_endpoint = null;

    public function __construct(\CarmaAPI\CarmaAPI $_api, RecipientListEndpoint $_rcpt_list_endpoint, $_list_id)
    {
        $this->recipients_list_endpoint = $_rcpt_list_endpoint;
        $this->list_id = $_list_id;
        parent::__construct($_api, "/lists/" . $_list_id . "/contacts");
    }

    public function getListId() { return $this->list_id; }

    public function getAll($_mode = ContactDto::PARAM_CONTACTS_LIST_MODE_ALL, $_params = array()) {
        $endpoint = "/{$_mode}" . ContactDto::generateQueryParams($_params);
        $resp = $this->api->getRequest($this->getUri($endpoint))->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\ContactDto')->getArrayCopy();
    }

    public function iterator($_mode = ContactDto::PARAM_CONTACTS_LIST_MODE_ALL, $_params = array()) {
        return new ContactListIterator($this, $_mode, $_params);
    }

    public function getByOriginalId($original_id) {
        return new ContactEndpoint($this->api, $this, $original_id);
    }

}
