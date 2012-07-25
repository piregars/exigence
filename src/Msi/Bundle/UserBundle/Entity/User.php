<?php

namespace Msi\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use FOS\UserBundle\Entity\User as BaseUser;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->setEnabled(true);
    }

    public function getId()
    {
        return $this->id;
    }
}
