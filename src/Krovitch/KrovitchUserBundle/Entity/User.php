<?php

namespace Krovitch\KrovitchUserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Krovitch\KrovitchUserBundle\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 * @UniqueEntity(fields="username", message="unramalak.errors.unique_username")
 * @UniqueEntity(fields="email", message="unramalak.errors.unique_email")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}