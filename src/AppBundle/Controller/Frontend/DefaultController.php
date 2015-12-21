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
    const ROUTE_HOMEPAGE = 'homepage';
    const ROUTE_FILMS = 'films';
    const ROUTE_ARTWORK = 'artwork';
    const ROUTE_NEWS = 'news';

    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        $items = $this->getDoctrine()->getRepository('AppBundle:Film')->findAllEnabledSortedByCreatedDateDesc();

        return $this->render('Frontend/homepage.html.twig', [ 'items' => $items ]);
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
