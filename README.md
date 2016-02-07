# Compost Carma API Implementation

This project aims to provide a native and easy-to-use PHP API for Compost Marketing Carma platform. Compost Carma is an email marketing platform mainly used for newsletter generation and recipients lists management. 

This API is built on the existing REST API provided by Compost (documentation available [here](http://www5.carmamail.com/mail/swagger#!/)).

*This project is still in early development - please do not use this in your project just yet*

### Configuration/Authentification

Use the `RESTAPIConfig` along the `RESTBasicAPIAuthentification` for now to authenticate with a valid API Username/Password combination.

``` php
<?php
use CarmaAPI\config\RESTAPIConfig;
use CarmaAPI\config\RESTBasicAPIAuthentification;
use CarmaAPI\CarmaAPI;

$cfg = new CarmaAPI\config\RESTAPIConfig("<server no>", "<customer id>");
$cfg->setAuthentification(new RESTBasicAPIAuthentification("<api username>", "<api password>"));
$api = new CarmaAPI($cfg);

```

### Endpoints

The API uses a series of endpoint as a mechanism to facilitate the overall use of the API. An endpoint represents a valid REST resource in Carma's API where some operations are available (list, create, delete, update, etc; your basic CRUD methods are generally present). Methods in the endpoints may have two purposes (*for now*):

- output model instances representing the actual data;
- another endpoint instance used to create a logical navigation between endpoints.

#### Current endpoints available

* `ContactEndpoint` - used for operations on a single contact in a recipient list
* `ContactsListEndpoint` - used for operations on contacts lists
* `RecipientListEndpoint` - used for operations on a single recipient list
* `RecipientsListsEndpoint` - used for operations on recipients lists

### Examples

#### Getting all the recipients lists

``` php
<?php
// ... configure & login to api and stuff ...
$lists = $api->lists()->getAll();
// $lists = array(\CarmaAPI\models\ListDto)
```

#### Iterating over all contacts of a list

``` php
<?php
foreach($api->lists()->getById(1)->contacts()->iterator(CarmaAPIConstants::CONTACTS_LIST_ITERATOR_UNSUBSCRIBED) as $unsubscribed_contact) {
  // $unsubscribed_contact = \CarmaAPI\models\ContactDto
  echo "I am unsubscribed :(";
}

foreach($api->lists()->getById(1)->contacts()->iterator(CarmaAPIConstants::CONTACTS_LIST_ITERATOR_BOUNCED) as $bounced_contact) {
  // $bounced_contact = \CarmaAPI\models\ContactDto
  echo "I bounced :(";
}

foreach($api->lists()->getById(1)->contacts()->iterator() as $contact) {
  // $contact = \CarmaAPI\models\ContactDto
  echo $contact->firstName . " " . $contact->lastName;
}
```

#### Getting messages of a given contact

``` php
<?php
$msgs = $api->lists()->contacts()->getByOriginalId("<originalid>")->messages();
// $msgs = array(\CarmaAPI\models\MessagesDto)

```

### Models

TODO