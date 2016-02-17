<?php namespace CarmaAPI\models;

class PropertyDto {
    public $id;

    public $propertyTypeId;

    public $name;

    public $description;

    public $dataType;

    public $dateCreated;

    public $dateModified;

    public $userCreated;

    public $staticProperty;

    /**
     * @var string[]
     */
    public $fileHeaders;
}

class ZapierAttributeDto {
    public $key;

    public $type;

    public $required;

    public $label;

    public $help_text;
}