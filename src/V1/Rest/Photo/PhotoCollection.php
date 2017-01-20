<?php
namespace ApigilityPhotoAlbum\V1\Rest\Photo;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareCollection;

class PhotoCollection extends ApigilityObjectStorageAwareCollection
{
    protected $itemType = PhotoEntity::class;
}
