<?php

namespace Krovitch\UnramalakBundle\Entity;

use Krovitch\BaseBundle\Entity\Entity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;

/**
 * @ORM\Entity(repositoryClass="Krovitch\UnramalakBundle\Repository\MediaRepository")
 * @ORM\Table(name="media")
 * @ORM\HasLifecycleCallbacks
 */
class Media extends Entity
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
     * @ORM\Column(type="string", length=100)
     * @Assert\File(maxSize = "2M", mimeTypes = {"image/png", "image/jpeg", "image/svg+xml"}, mimeTypesMessage = "Please upload a png, a svg or a jpg lower than 2M")
     */
    protected $file;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $type;

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        die('TODO file handling');
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
     * @param $file
     * @internal param int $level
     * @return Unit
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set life
     *
     * @param $type
     * @internal param int $life
     * @return Unit
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get life
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }
}