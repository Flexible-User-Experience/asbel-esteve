<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\DescriptionTrait;
use AppBundle\Entity\Traits\TitleTrait;
use AppBundle\Entity\Traits\SlugTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Page class
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   David Romaní <david@flux.cat>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageRepository")
 */
class Page extends AbstractBase
{
    use TitleTrait;
    use SlugTrait;
    use DescriptionTrait;
}
