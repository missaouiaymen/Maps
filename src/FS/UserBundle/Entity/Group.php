<?php
// src/AppBundle/Entity/Group.php

namespace FS\UserBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="group")
*/
class Group extends BaseGroup
{
/**
* @ORM\Id
* @ORM\Column(type="integer")
* @ORM\GeneratedValue(strategy="AUTO")
*/
protected $id;


    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
     * @ORM\JoinTable(name="user_user_group",
     *     joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")})
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct($name, $roles)
    {
        parent::__construct($name, $roles);
        $this->users = new ArrayCollection();
    }


    /**
     * Add user
     *
     * @param \FS\UserBundle\Entity\User $user
     *
     * @return Group
     */
    public function addUser(\FS\UserBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \FS\UserBundle\Entity\User $user
     */
    public function removeUser(\FS\UserBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }
}
