<?php namespace CarmaAPI\models;


class TriggerDto {
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
}

class LinkDto {
    public $id;

    public $name;

    public $linkTarget;

    /**
     * @var string[]
     */
    public $tags;
}

class BlockLinkTagDto {
    public $blockLinkId;

    public $tag;
}