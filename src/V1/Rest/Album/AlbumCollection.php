<?php
namespace ApigilityPhotoAlbum\V1\Rest\Album;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareCollection;

class AlbumCollection extends ApigilityObjectStorageAwareCollection
{
    protected $itemType = AlbumEntity::class;
}
