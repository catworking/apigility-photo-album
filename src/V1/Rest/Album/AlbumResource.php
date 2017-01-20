<?php
namespace ApigilityPhotoAlbum\V1\Rest\Album;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class AlbumResource extends ApigilityResource
{
    /**
     * @var \ApigilityPhotoAlbum\Service\AlbumService
     */
    protected $albumService;

    /**
     * @var \ApigilityUser\Service\UserService
     */
    protected $userService;

    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->albumService = $services->get('ApigilityPhotoAlbum\Service\AlbumService');
        $this->userService = $services->get('ApigilityUser\Service\UserService');
    }

    public function create($data)
    {
        try {
            $auth_user = $this->userService->getAuthUser();
            return new AlbumEntity($this->albumService->createAlbum($data, $auth_user), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function patch($id, $data)
    {
        try {
            $auth_user = $this->userService->getAuthUser();
            return new AlbumEntity($this->albumService->updateAlbum($id, $data, $auth_user), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetch($id)
    {
        try {
            return new AlbumEntity($this->albumService->getAlbum($id), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetchAll($params = [])
    {
        try {
            return new AlbumCollection($this->albumService->getAlbums($params), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $auth_user = $this->userService->getAuthUser();
            return $this->albumService->deleteAlbum($id, $auth_user->getId());
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}
