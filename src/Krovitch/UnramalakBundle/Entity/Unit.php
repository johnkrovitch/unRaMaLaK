<?php

namespace Krovitch\UnramalakBundle\Entity;

use Krovitch\BaseBundle\Entity\Entity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;

/**
 * @ORM\Entity(repositoryClass="Krovitch\UnramalakBundle\Repository\UnitRepository")
 * @ORM\Table(name="unit")
 * @ORM\InheritanceType("JOINED")
 * @ORM\HasLifecycleCallbacks
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap({"unit" = "Unit", "hero" = "Hero"})
 */
class Unit extends Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $level;

    /**
     * @ORM\Column(type="integer")
     */
    protected $life;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\File(maxSize = "2M", mimeTypes = {"image/png", "image/jpeg"}, mimeTypesMessage = "Please upload a png or a jpg lower than 2M")
     */
    protected $avatar;

    /**
     * @ORM\ManyToOne(targetEntity="Race", inversedBy="members")
     */
    protected $race;

    protected $uploadDir;

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if ($this->getAvatar() !== null) {
            // generate unique path
            $filename = $this->getAvatar()->getBasename() . sha1(uniqid(mt_rand(), true)) . '.' . $this->getAvatar()->guessExtension();
            $path = $this->getAvatar()->move($this->getUploadRootDir(), $filename);
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    public function getUploadRootDir()
    {
        // default parameter
        if (!$this->uploadDir) {
            $this->uploadDir = '/web/bundles/krovitch/uploads';
        }
        return __DIR__ . '/../../../../' . $this->uploadDir;
    }

    public function setUploadDir($dir)
    {
        $this->uploadDir = $dir;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Unit
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Unit
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set life
     *
     * @param integer $life
     * @return Unit
     */
    public function setLife($life)
    {
        $this->life = $life;

        return $this;
    }

    /**
     * Get life
     *
     * @return integer
     */
    public function getLife()
    {
        return $this->life;
    }

    /**
     * Set avatar
     *
     * @param File $avatar
     * @return Unit
     */
    public function setAvatar(File $avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return File
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set race
     *
     * @param \Krovitch\UnramalakBundle\Entity\Race $race
     * @return Unit
     */
    public function setRace(Race $race = null)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Get race
     *
     * @return \Krovitch\UnramalakBundle\Entity\Race
     */
    public function getRace()
    {
        return $this->race;
    }
}