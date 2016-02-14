<?php namespace CarmaAPI\models;

class ContactDto {

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
}

class BounceStatusDto {
    public $status;
}

class SubscriptionStatusDto {
    public $status;

    public $mobileStatus;
}