<?php
namespace ApigilityPhotoAlbum\V1\Rest\Album;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareEntity;
use ApigilityUser\DoctrineEntity\User;
use ApigilityUser\V1\Rest\User\UserEntity;

class AlbumEntity extends ApigilityObjectStorageAwareEntity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 相册名称
     *
     * @Column(type="string", length=200, nullable=true)
     */
    protected $name;

    /**
     * 创建时间
     *
     * @Column(type="datetime", nullable=false)
     */
    protected $create_time;

    /**
     * 默认相册
     *
     * @Column(type="smallint", nullable=false, options={"default":0})
     */
    protected $is_default;

    /**
     * 所有者，ApigilityUser组件的User对象
     *
     * @ManyToOne(targetEntity="ApigilityUser\DoctrineEntity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * 相册中的照片
     *
     * @OneToMany(targetEntity="Photo", mappedBy="album")
     */
    protected $photos;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
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

    public function setIsDefault($default)
    {
        $this->is_default = $default;
        return $this;
    }

    public function getIsDefault()
    {
        return (boolean)$this->is_default;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        if ($this->user instanceof User) return $this->hydrator->extract(new UserEntity($this->user, $this->serviceManager));
        else return $this->user;
    }

    public function setPhotos($photos)
    {
        $this->photos = $photos;
        return $this;
    }

    public function getPhotos()
    {
        return $this->photos->count();
    }
}
