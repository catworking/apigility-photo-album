<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/22
 * Time: 12:00:14
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
 * Class Photo
 * @package ApigilityPhotoAlbum\DoctrineEntity
 * @Entity @Table(name="apigilityphotoalbum_photo")
 */
class Photo
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
        return $this->uri;
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

    public function setAlbum($album)
    {
        $this->album = $album;
        return $this;
    }

    /**
     * @return Album
     */
    public function getAlbum()
    {
        return $this->album;
    }
}