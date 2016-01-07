<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\TitleTrait;
use AppBundle\Entity\Traits\SlugTrait;
use AppBundle\Entity\Traits\DescriptionTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @var File
     *
     * @Vich\UploadableField(mapping="uploads", fileNameProperty="imageName")
     * @Assert\File(
     *     maxSize = "10M",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/png", "image/gif"}
     * )
     * @Assert\Image(minWidth = 1200)
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $metaKeywords;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $metaDescription;

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
     * Set imageFile
     *
     * @param File|UploadedFile $imageFile
     *
     * @return Film
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * Get imageFile
     *
     * @return File|UploadedFile
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return Film
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }
    /**
     * Set MetaKeywords
     *
     * @param string $metaKeywords
     *
     * @return Film
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get MetaKeywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set MetaDescription
     *
     * @param string $metaDescription
     *
     * @return Film
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get MetaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
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
        $this->categories[] = $category;

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
}
