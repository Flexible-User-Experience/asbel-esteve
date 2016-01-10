<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\TitleTrait;
use AppBundle\Entity\Traits\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   David Romaní <david@flux.cat>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category extends AbstractBase
{
    use TitleTrait;
    use SlugTrait;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Film", mappedBy="categories")
     */
    private $films;

    /**
     *
     *
     * Methods
     *
     *
     */

    /**
     * Category constructor
     */
    public function __construct()
    {
        $this->films = new ArrayCollection();
    }

    /**
     * Set films
     *
     * @param ArrayCollection $films
     *
     * @return Category
     */
    public function setFilms(ArrayCollection $films)
    {
        $this->films = $films;

        return $this;
    }

    /**
     * Get films
     *
     * @return ArrayCollection
     */
    public function getFilms()
    {
        return $this->films;
    }

    /**
     * Add Film
     *
     * @param Film $film
     *
     * @return Category
     */
    public function addFilm(Film $film)
    {
        $this->films->add($film);

        return $this;
    }

    /**
     * Remove film
     *
     * @param Film $film
     *
     * @return Category
     */
    public function removeFilm(Film $film)
    {
        $this->films->removeElement($film);

        return $this;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString() {

        return $this->title ? $this->getTitle() : '---';
    }
}
