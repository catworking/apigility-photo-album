<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/22
 * Time: 12:00:03
 */
namespace ApigilityPhotoAlbum\DoctrineEntity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;
use ApigilityUser\DoctrineEntity\User;

/**
 * Class Album
 * @package ApigilityPhotoAlbum\DoctrineEntity
 * @Entity @Table(name="apigilityphotoalbum_album")
 */
class Album
{
    const DEFAULT_YES = 1;
    const DEFAULT_NO = 0;

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

    public function __construct() {
        $this->photos = new ArrayCollection();
    }

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
        return $this->create_time;
    }

    public function setIsDefault($default)
    {
        $this->is_default = $default;
        return $this;
    }

    public function getIsDefault()
    {
        return $this->is_default;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setPhotos($photos)
    {
        $this->photos = $photos;
        return $this;
    }

    public function getPhotos()
    {
        return $this->photos;
    }

    public function addPhoto($photo)
    {
        $this->photos[] = $photo;
        return $this;
    }
}