<?php

namespace Msi\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use Msi\Bundle\ImaginatorBundle\Imaginator\Imaginator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="user_team")
 * @ORM\Entity
* @ORM\HasLifecycleCallbacks
 */
class Team
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(unique=true)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(unique=true)
     * @Assert\NotBlank()
     */
    protected $slug;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $game;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="integer")
     */
    protected $position;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     */
    protected $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="team")
     */
    protected $users;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $logoName;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $logoPath;

    /**
     * @Assert\File(maxSize="6000000")
     */
    protected $logoFile;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->enabled = false;
        $this->position = 1;
        $this->users = new ArrayCollection();
    }

    public function getUploadDir()
    {
        return __DIR__.'/../../../../../web/uploads/teams/logos/';
    }

    public function removeFile()
    {
        $file = $this->getUploadDir().$this->logoName;
        if (is_file($file)) unlink($file);

        $file = $this->getUploadDir().'t_'.$this->logoName;
        if (is_file($file)) unlink($file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $this->removeFile();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function postUpload()
    {
        if ($this->logoFile === null) return;

        $this->logoFile->move($this->getUploadDir(), $this->logoName);

        $im = new Imaginator($this->getUploadDir().$this->logoName);

        $im->resize(298, 100)->save();
        $im->resize(610, 190)->saveAs($this->getUploadDir().'t_'.$this->logoName);

        unset($this->logoFile);
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        $this->updatedAt = new \DateTime();

        if ($this->logoFile === null) return;

        $ext = $this->logoFile->guessExtension();

        if (!in_array($ext, array('jpg', 'jpeg', 'gif', 'png'))) {
            die('The file must be either jpg or png or gif.');
        }

        $this->removeFile();
        $this->logoName = uniqid(time()).'.'.$ext;
        $this->logoPath = '/uploads/teams/logos/';
    }

    public function getLogo()
    {
        return $this->logoPath.$this->logoName;
    }

    public function getLogoName()
    {
        return $this->logoName;
    }

    public function setLogoName($logoName)
    {
        $this->logoName = $logoName;

        return $this;
    }

    public function getLogoPath()
    {
        return $this->logoPath;
    }

    public function setLogoPath($logoPath)
    {
        $this->logoPath = $logoPath;

        return $this;
    }

    public function getLogoFile()
    {
        return $this->logoFile;
    }

    public function setLogoFile($logoFile)
    {
        $this->logoFile = $logoFile;
        $this->updatedAt = new \DateTime();

        return $this;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getGame()
    {
        return $this->game;
    }

    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    public function getEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        $this->slug = \Msi\Bundle\PageBundle\Entity\Page::slugify($this->name);

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->id;
    }
}
