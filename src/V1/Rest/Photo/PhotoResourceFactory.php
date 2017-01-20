<?php
namespace ApigilityPhotoAlbum\V1\Rest\Photo;

class PhotoResourceFactory
{
    public function __invoke($services)
    {
        return new PhotoResource($services);
    }
}
