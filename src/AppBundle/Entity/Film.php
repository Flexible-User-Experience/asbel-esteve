<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\TitleTrait;
use AppBundle\Entity\Traits\SlugTrait;
use AppBundle\Entity\Traits\DescriptionTrait;
use AppBundle\Entity\Traits\ImageTrait;
use AppBundle\Entity\Traits\MetaKeywordsTrait;
use AppBundle\Entity\Traits\MetaDescriptionTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class Film
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   David Romaní <david@flux.cat>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FilmRepository")
 * @Vich\Uploadable
 */
class Film extends AbstractBase
{
    use TitleTrait;
    use SlugTrait;
    use DescriptionTrait;
    use ImageTrait;
    use MetaKeywordsTrait;
    use MetaDescriptionTrait;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="main", fileNameProperty="imageName")
     * @Assert\File(
     *     maxSize = "10M",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/png", "image/gif"}
     * )
     * @Assert\Image(minWidth = 1200)
     */
    private $imageFile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

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
     * @Assert\Url(checkDNS=true)
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
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="films")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $categories;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="FilmImage", mappedBy="film", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $images;

    /**
     *
     *
     * Methods
     *
     *
     */

    /**
     * Film constructor
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    /**
     * Set PublishedAt
     *
     * @param \DateTime $date
     *
     * @return Film
     */
    public function setPublishedAt(\DateTime $date)
    {
        $this->publishedAt = $date;

        return $this;
    }

    /**
     * Get PublishedAt
     *
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
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
     * Get urlVimeo
     *
     * @return int
     */
    public function getVimeoId()
    {
        $result = null;
        if ($this->urlVimeo) {
            $arr = explode('/', $this->getUrlVimeo());
            $result = intval(array_pop($arr));
        }

        return $result;
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

    /**
     * Set categories
     *
     * @param ArrayCollection $categories
     *
     * @return Film
     */
    public function setCategories(ArrayCollection $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add category
     *
     * @param Category $category
     *
     * @return Film
     */
    public function addCategory(Category $category)
    {
        $category->addFilm($this);
        $this->categories->add($category);

        return $this;
    }

    /**
     * Remove category
     *
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Set images
     *
     * @param ArrayCollection $images
     *
     * @return Film
     */
    public function setImages(ArrayCollection $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add image
     *
     * @param FilmImage $image
     *
     * @return Film
     */
    public function addImage(FilmImage $image)
    {
        $image->setFilm($this);
        $this->images->add($image);

        return $this;
    }

    /**
     * Remove image
     *
     * @param FilmImage $image
     */
    public function removeImage(FilmImage $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->id ? '#' . $this->getId() . ' · ' . $this->getTitle() :  '---';
    }
}
