<?php
namespace CarmaAPI\endpoints\iterators;
use CarmaAPI\constants\CarmaAPIConstants;
use CarmaAPI\endpoints\ContactsListEndpoint;
use CarmaAPI\models\ContactDto;

class ContactListIterator implements \Iterator {
    private $currentListEndpoint = null;
    /**
     * @var ContactDto[]
     */
    private $currentList = array();
    private $listPageSize = 0;
    private $mode = CarmaAPIConstants::CONTACTS_LIST_ITERATOR_ALL;
    private $currIndex = 0;

    public function __construct(ContactsListEndpoint $_endpoint, $_mode, $_list_size)
    {
        $this->mode = $_mode;
        $this->listPageSize = $_list_size;
        $this->currentListEndpoint = $_endpoint;
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
            $this->currentList = $this->currentListEndpoint->getAll(
                $this->mode,
                ContactsListEndpoint::DEFAULT_INCLUDE_PROPERTIES,
                $this->listPageSize, $last_id);

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

class ContactsListEndpoint extends APIEndpoint {
    private $list_id;
    private $recipients_list_endpoint = null;

    const DEFAULT_PAGE_SIZE = 1000;
    const DEFAULT_INCLUDE_PROPERTIES = true;

    public function __construct(\CarmaAPI\CarmaAPI $_api, RecipientListEndpoint $_rcpt_list_endpoint, $_list_id)
    {
        $this->recipients_list_endpoint = $_rcpt_list_endpoint;
        $this->list_id = $_list_id;
        parent::__construct($_api, "/lists/" . $_list_id . "/contacts");
    }

    public function getListId() { return $this->list_id; }

    public function getAll($_mode = CarmaAPIConstants::CONTACTS_LIST_ITERATOR_ALL, $_include_properties = self::DEFAULT_INCLUDE_PROPERTIES, $_page_size = self::DEFAULT_PAGE_SIZE, $_last_id = -1) {
        $_include_properties = $_include_properties ? "true" : "false";
        $resp = $this->api->getRequest($this->getUri("/{$_mode}?pageSize={$_page_size}&lastId={$_last_id}&includeProperties={$_include_properties}"))->send();
        $this->handleResponseErrorIfAny($resp);

        return $this->api->getMapper()->mapArray($resp->body, new \ArrayObject(), '\CarmaAPI\models\ContactDto')->getArrayCopy();
    }

    public function iterator($_mode = CarmaAPIConstants::CONTACTS_LIST_ITERATOR_ALL, $_page_size = self::DEFAULT_PAGE_SIZE) {
        return new ContactListIterator($this, $_mode, $_page_size);
    }

    public function getByOriginalId($original_id) {
        return new ContactEndpoint($this->api, $this, $original_id);
    }

}
