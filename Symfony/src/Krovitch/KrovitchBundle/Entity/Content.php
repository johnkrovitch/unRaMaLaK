<?php

namespace Krovitch\KrovitchBundle\Entity;

use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Krovitch\KrovitchBundle\Repository\ContentRepository")
 * @ORM\Table(name="content")
 */
class Content extends Entity
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\Column(type="string", length=100)
   * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
   * @Assert\Length(minLength=3, maxLength=10)
   */
  protected $title;

  /**
   * @ORM\Column(type="text")
   * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
   * @Assert\Length(minLength=3, maxLength=10)
   */
  protected $content;

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
   * Set title
   *
   * @param string $title
   * @return void
   */
  public function setTitle($title)
  {
      $this->title = $title;
  }

  /**
   * Get title
   *
   * @return string
   */
  public function getTitle()
  {
      return $this->title;
  }

  /**
   * Set content
   *
   * @param text $content
   */
  public function setContent($content)
  {
      $this->content = $content;
  }

  /**
   * Get content
   *
   * @return text
   */
  public function getContent()
  {
      return $this->content;
  }
}