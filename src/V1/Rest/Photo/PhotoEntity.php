<?php
namespace ApigilityPhotoAlbum\V1\Rest\Photo;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareEntity;
use ApigilityPhotoAlbum\DoctrineEntity\Album;
use ApigilityPhotoAlbum\V1\Rest\Album\AlbumEntity;
use ApigilityUser\DoctrineEntity\User;
use ApigilityUser\V1\Rest\User\UserEntity;

class PhotoEntity extends ApigilityObjectStorageAwareEntity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 照片标题
     *
     * @Column(type="string", length=200, nullable=true)
     */
    protected $title;

    /**
     * 照片地址
     *
     * @Column(type="string", length=255, nullable=false)
     */
    protected $uri;

    /**
     * 创建时间
     *
     * @Column(type="datetime", nullable=false)
     */
    protected $create_time;

    /**
     * 所有者，ApigilityUser组件的User对象
     *
     * @ManyToOne(targetEntity="ApigilityUser\DoctrineEntity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * 所属相册
     *
     * @ManyToOne(targetEntity="Album", inversedBy="photos")
     * @JoinColumn(name="album_id", referencedColumnName="id")
     */
    protected $album;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    public function getUri()
    {
        return $this->renderUriToUrl($this->uri);
    }

    public function setCreateTime(\DateTime $create_time)
    {
        $this->create_time = $create_time;
        return $this;
    }

    public function getCreateTime()
    {
        if ($this->create_time instanceof \DateTime) return $this->create_time->getTimestamp();
        else return $this->create_time;
    }

    public function setAlbum($album)
    {
        $this->album = $album;
        return $this;
    }

    public function getAlbum()
    {
        if ($this->album instanceof Album) return $this->hydrator->extract(new AlbumEntity($this->album, $this->serviceManager));
        else return $this->album;
    }
}
