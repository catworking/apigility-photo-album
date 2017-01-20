<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/22
 * Time: 12:00:45
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

class AlbumService
{
    protected $classMethodsHydrator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct(ServiceManager $services)
    {
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
    }

    /**
     * 创建一个相册
     *
     * @param $data
     * @param $user
     * @return DoctrineEntity\Album
     */
    public function createAlbum($data, $user)
    {
        $album = new DoctrineEntity\Album();
        if (isset($data->name)) $album->setName($data->name);
        $album->setCreateTime(new \DateTime());
        if (isset($data->is_default)) $album->setIsDefault((boolean)$data->is_default);
        $album->setUser($user);

        $this->em->persist($album);
        $this->em->flush();

        return $album;
    }

    /**
     * 获取一个相册
     *
     * @param $album_id
     * @return DoctrineEntity\Album
     * @throws \Exception
     */
    public function getAlbum($album_id)
    {
        $album = $this->em->find('ApigilityPhotoAlbum\DoctrineEntity\Album', $album_id);
        if (empty($album)) throw new \Exception('相册不存在', 404);
        else return $album;
    }

    /**
     * 设置用户的默认相册
     *
     * @param $album_id
     * @return DoctrineEntity\Album
     */
    public function setDefaultAlbum($album_id)
    {
        $album = $this->getAlbum($album_id);

        $qb = new QueryBuilder($this->em);
        $qb->update('ApigilityPhotoAlbum\DoctrineEntity\Album', 'a')
            ->set('a.default', false)
            ->where('a.id != :album_id AND a.user.id = :user_id');
        $qb->setParameters([
            'album_id' => $album_id,
            'user_id' => $album->getUser()->getId()
        ]);

        $qb->getQuery()->execute();

        $album->setIsDefault(DoctrineEntity\Album::DEFAULT_YES);
        $this->em->flush();

        return $album;
    }

    /**
     * 获取用户的默认相册
     *
     * @param User $user
     * @return \ApigilityPhotoAlbum\DoctrineEntity\Album
     */
    public function getDefaultAlbum(User $user)
    {
        $album = $this->em->getRepository('ApigilityPhotoAlbum\DoctrineEntity\Album')
            ->findOneBy([
                'user'=>$user,
                'is_default'=>DoctrineEntity\Album::DEFAULT_YES
            ]);

        return $album;
    }

    /**
     * 获取相册列表
     *
     * @param $params
     * @return DoctrinePaginatorAdapter
     */
    public function getAlbums($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('a')->from('ApigilityPhotoAlbum\DoctrineEntity\Album', 'a');

        $where = '';

        if (isset($params->user_id)) {
            $qb->innerJoin('a.user', 'user');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'user.id = :user_id';
        }

        if (!empty($where)) {
            $qb->where($where);
            if (isset($params->user_id)) $qb->setParameter('user_id', $params->user_id);
        }

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    /**
     * 修改相册
     *
     * @param $album_id
     * @param $data
     * @param  User $user
     * @return DoctrineEntity\Album
     * @throws \Exception
     */
    public function updateAlbum($album_id, $data, User $user)
    {
        $album = $this->getAlbum($album_id);

        if ($album->getUser()->getId() === $user->getId()) {
            if (isset($data->name)) $album->setName($data->name);
            $this->em->flush();
        } else {
            throw new \Exception('没有修改此相册的权限', 403);
        }

        return $album;
    }

    /**
     * 删除一个相册
     *
     * @param $album_id
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function deleteAlbum($album_id, User $user)
    {
        $album = $this->getAlbum($album_id);

        if ($album->getUser()->getId() === $user->getId()) {
            $this->em->remove($album);
            $this->em->flush();
        } else {
            throw new \Exception('没有删除此相册的权限', 403);
        }

        return true;
    }
}