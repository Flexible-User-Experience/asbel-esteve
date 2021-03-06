<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\ImageTrait;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Category
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   David Romaní <david@flux.cat>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FilmImageRepository")
 * @Vich\Uploadable
 */
class FilmImage extends AbstractBase
{
    use ImageTrait;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="secondary", fileNameProperty="imageName")
     * @Assert\File(
     *     maxSize = "10M",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/png", "image/gif"}
     * )
     * @Assert\Image(minWidth = 1200)
     */
    private $imageFile;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $position = 1;

    /**
     * @var Film
     *
     * @ORM\ManyToOne(targetEntity="Film", inversedBy="images")
     */
    private $film;

    /**
     *
     *
     * Methods
     *
     *
     */

    /**
     * Set Position
     *
     * @param int $position
     *
     * @return FilmImage
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get Position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set film
     *
     * @param Film $film
     *
     * @return FilmImage
     */
    public function setFilm(Film $film)
    {
        $this->film = $film;

        return $this;
    }

    /**
     * Get film
     *
     * @return Film
     */
    public function getFilm()
    {
        return $this->film;
    }
}
