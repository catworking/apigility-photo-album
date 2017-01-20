<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/9
 * Time: 11:02
 */
namespace ApigilityPhotoAlbum;

use ApigilityPhotoAlbum\DoctrineEntity\Album;
use ApigilityUser\Service\UserService;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\EventManager\EventInterface;
use Zend\ServiceManager\ServiceManager;

class AlbumListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    private $services;

    /**
     * @var \ApigilityPhotoAlbum\Service\AlbumService
     */
    private $albumService;

    public function __construct(ServiceManager $services)
    {
        $this->services = $services;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(UserService::EVENT_USER_CREATED, [$this, 'createDefaultAlbum'], $priority);
    }

    public function createDefaultAlbum(EventInterface $e)
    {
        $params = $e->getParams();

        // 创建默认相册
        $this->albumService = $this->services->get('ApigilityPhotoAlbum\Service\AlbumService');
        $album_data = new \stdClass();
        $album_data->name = '默认相册';
        $album_data->is_default = Album::DEFAULT_YES;
        $this->albumService->createAlbum($album_data, $params['user']);
    }
}