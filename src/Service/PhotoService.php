<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/22
 * Time: 12:01:12
 */
namespace ApigilityPhotoAlbum\Service;

use ApigilityUser\DoctrineEntity\Identity;
use ApigilityUser\DoctrineEntity\User;
use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use ApigilityPhotoAlbum\DoctrineEntity;

class PhotoService
{
    protected $classMethodsHydrator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var AlbumService
     */
    protected $albumService;

    public function __construct(ServiceManager $services)
    {
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
        $this->albumService = $services->get('ApigilityPhotoAlbum\Service\AlbumService');
    }

    /**
     * 创建一个照片
     *
     * @param $data
     * @param $user
     * @return DoctrineEntity\Photo
     */
    public function createPhoto($data, User $user)
    {
        $photo = new DoctrineEntity\Photo();
        if (isset($data->title)) $photo->setTitle($data->title);
        $photo->setUri($data->uri);
        $photo->setUser($user);

        if (isset($data->album_id)) $photo->setAlbum($this->albumService->getAlbum($data->album_id));
        else $photo->setAlbum($this->albumService->getDefaultAlbum($user));

        $photo->setCreateTime(new \DateTime());

        $this->em->persist($photo);
        $this->em->flush();

        return $photo;
    }

    /**
     * 获取一个照片
     *
     * @param $photo_id
     * @return DoctrineEntity\Photo
     * @throws \Exception
     */
    public function getPhoto($photo_id)
    {
        $photo = $this->em->find('ApigilityPhotoAlbum\DoctrineEntity\Photo', $photo_id);
        if (empty($photo)) throw new \Exception('照片不存在', 404);
        else return $photo;
    }

    /**
     * 获取照片列表
     *
     * @param $params
     * @return DoctrinePaginatorAdapter
     */
    public function getPhotos($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('p')->from('ApigilityPhotoAlbum\DoctrineEntity\Photo', 'p');

        $where = '';

        if (isset($params->user_id)) {
            $qb->innerJoin('p.user', 'user');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'user.id = :user_id';
        }

        if (isset($params->album_id)) {
            $qb->innerJoin('p.album', 'pa');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'pa.id = :album_id';
        }

        if (!empty($where)) {
            $qb->where($where);
            if (isset($params->user_id)) $qb->setParameter('user_id', $params->user_id);
            if (isset($params->album_id)) $qb->setParameter('album_id', $params->album_id);
        }

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    /**
     * 修改照片
     *
     * @param $photo_id
     * @param $data
     * @param User $user
     * @return DoctrineEntity\Photo
     * @throws \Exception
     */
    public function updatePhoto($photo_id, $data, User $user)
    {
        $photo = $this->getPhoto($photo_id);

        if ($photo->getUser()->getId() === $user->getId()) {
            if (isset($data->title)) $photo->setTitle($data->title);
            if (isset($data->album_id)) $photo->setAlbum($this->albumService->getAlbum($data->album_id));
            $this->em->flush();
        } else {
            throw new \Exception('没有修改此照片的权限', 403);
        }

        return $photo;
    }

    /**
     * 删除一个照片
     *
     * @param $photo_id
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function deletePhoto($photo_id, User $user)
    {
        $photo = $this->getPhoto($photo_id);

        if ($photo->getUser()->getId() === $user->getId()) {
            $this->em->remove($photo);
            $this->em->flush();
        } else {
            throw new \Exception('没有删除此照片的权限', 403);
        }

        return true;
    }

    /**
     * 删除多个照片
     *
     * @param $photo_ids
     * @param $album_id
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function deletePhotos($photo_ids, $album_id, User $user)
    {
        foreach ($photo_ids as $photo_id) {
            $photo = $this->getPhoto($photo_id);

            if ($photo->getAlbum()->getId() !== $album_id) {
                throw new \Exception('照片不在指定的相册中，无权删除', 403);
            }

            if ($photo->getUser()->getId() === $user->getId()) {
                $this->em->remove($photo);
                $this->em->flush();
            } else {
                throw new \Exception('没有删除此照片的权限', 403);
            }
        }

        return true;
    }
}