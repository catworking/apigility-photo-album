<?php
namespace ApigilityPhotoAlbum\V1\Rest\Photo;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class PhotoResource extends ApigilityResource
{
    /**
     * @var \ApigilityPhotoAlbum\Service\PhotoService
     */
    protected $photoService;

    /**
     * @var \ApigilityUser\Service\UserService
     */
    protected $userService;

    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->photoService = $services->get('ApigilityPhotoAlbum\Service\PhotoService');
        $this->userService = $services->get('ApigilityUser\Service\UserService');
    }



    public function create($data)
    {
        try {
            $auth_user = $this->userService->getAuthUser();
            return new PhotoEntity($this->photoService->createPhoto($data, $auth_user), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function patch($id, $data)
    {
        try {
            $auth_user = $this->userService->getAuthUser();
            return new PhotoEntity($this->photoService->updatePhoto($id, $data, $auth_user), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetch($id)
    {
        try {
            return new PhotoEntity($this->photoService->getPhoto($id), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetchAll($params = [])
    {
        try {
            return new PhotoCollection($this->photoService->getPhotos($params), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $auth_user = $this->userService->getAuthUser();
            return $this->photoService->deletePhoto($id, $auth_user);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function deleteList($data)
    {
        try {
            $auth_user = $this->userService->getAuthUser();
            return $this->photoService->deletePhotos($data['ids'], $data['album_id'], $auth_user);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}
