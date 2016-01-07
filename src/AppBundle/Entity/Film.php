<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\DescriptionTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Film
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   David Romaní <david@flux.cat>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FilmRepository")
 */
class Film extends AbstractBase
{
    use DescriptionTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $year = 2000;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlVimeo;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\Range(min=3, max=12)
     */
    private $bootstrapColumns = 3;

    /**
     *
     *
     * Methods
     *
     *
     */

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Film
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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
     * Set Slug
     *
     * @param string $slug
     *
     * @return Film
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get Slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Film
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set urlVimeo
     *
     * @param string $urlVimeo
     *
     * @return Film
     */
    public function setUrlVimeo($urlVimeo)
    {
        $this->urlVimeo = $urlVimeo;

        return $this;
    }

    /**
     * Get urlVimeo
     *
     * @return string
     */
    public function getUrlVimeo()
    {
        return $this->urlVimeo;
    }

    /**
     * Set BootstrapColumns
     *
     * @param int $bootstrapColumns
     *
     * @return Film
     */
    public function setBootstrapColumns($bootstrapColumns)
    {
        $this->bootstrapColumns = $bootstrapColumns;

        return $this;
    }

    /**
     * Get BootstrapColumns
     *
     * @return int
     */
    public function getBootstrapColumns()
    {
        return $this->bootstrapColumns;
    }
}
