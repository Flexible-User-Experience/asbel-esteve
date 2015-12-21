<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 *
 * @category Controller
 * @package  AppBundle\Controller\Frontend
 * @author   David Romaní <david@flux.cat>
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        return $this->render('Frontend/homepage.html.twig');
    }

    /**
     * @Route("/films", name="films")
     */
    public function filmsAction()
    {
        return $this->render('Frontend/films.html.twig');
    }

    /**
     * @Route("/artwork", name="artwork")
     */
    public function artworkAction()
    {
        return $this->render('Frontend/artwork.html.twig');
    }

    /**
     * @Route("/news", name="news")
     */
    public function newsAction()
    {
        return $this->render('Frontend/news.html.twig');
    }
}
