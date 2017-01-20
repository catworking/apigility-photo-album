<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/22
 * Time: 12:00:57
 */
namespace ApigilityPhotoAlbum\Service;

use Zend\ServiceManager\ServiceManager;

class AlbumServiceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new AlbumService($services);
    }
}