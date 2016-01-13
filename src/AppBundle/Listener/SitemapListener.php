<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Presta\SitemapBundle\Service\SitemapListenerInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

/**
 * Class SitemapListener
 *
 * @category Listener
 * @package  Acme\DemoBundle\EventListener
 * @author   David Romaní <david@flux.cat>
 */
class SitemapListener implements SitemapListenerInterface
{
    /** @var RouterInterface */
    private $router;

    /** @var EntityManager */
    private $em;

    /**
     * @var ArrayCollection all categories enabled sorted by title
     */
    private $categories;

    /**
     * @var ArrayCollection all static pages sorted by title
     */
    private $pages;

    /**
     * SitemapListener constructor
     *
     * @param RouterInterface $router
     * @param EntityManager   $em
     */
    public function __construct(RouterInterface $router, EntityManager $em)
    {
        $this->router = $router;
        $this->em = $em;
        $this->categories = $this->em->getRepository('AppBundle:Category')->findAllEnabledSortedByTitle();
        $this->pages = $this->em->getRepository('AppBundle:Page')->findAllSortedByTitle();
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populateSitemap(SitemapPopulateEvent $event)
    {
        $section = $event->getSection();
        if (is_null($section) || $section == 'default') {
            // get absolute homepage url
            $url = $this->router->generate('app_homepage', array(), UrlGeneratorInterface::ABSOLUTE_URL);

            // add homepage url to the urlset named default
            $event
                ->getGenerator()
                ->addUrl(
                    new UrlConcrete(
                        $url,
                        new \DateTime(),
                        UrlConcrete::CHANGEFREQ_HOURLY,
                        1
                    ),
                    'default'
                );
            /** @var Category $category */
            foreach ($this->categories as $category) {
                $url = $this->router->generate('app_category', array('slug' => $category->getSlug()), UrlGeneratorInterface::ABSOLUTE_URL);
                $event
                    ->getGenerator()
                    ->addUrl(
                    new UrlConcrete(
                        $url,
                        new \DateTime(),
                        UrlConcrete::CHANGEFREQ_DAILY,
                        1
                    ),
                    'default'
                );
            }
        }
    }
}
