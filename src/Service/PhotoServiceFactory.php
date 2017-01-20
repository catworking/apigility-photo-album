<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/22
 * Time: 12:01:24
 */
namespace ApigilityPhotoAlbum\Service;

use Zend\ServiceManager\ServiceManager;

class PhotoServiceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new PhotoService($services);
    }
}