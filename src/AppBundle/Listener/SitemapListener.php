<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Category;
use AppBundle\Entity\Film;
use AppBundle\Entity\Page;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Presta\SitemapBundle\Service\SitemapListenerInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

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

    /** @var ArrayCollection */
    private $categories;

    /** @var ArrayCollection */
    private $contentPages;

    /** @var ArrayCollection */
    private $staticPages;

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
        $this->contentPages = $this->em->getRepository('AppBundle:Film')->findAllEnabledSortedByPublishDateDescWithJoin(
        );
        $this->staticPages = $this->em->getRepository('AppBundle:Page')->findAllSortedByTitle();
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populateSitemap(SitemapPopulateEvent $event)
    {
        $section = $event->getSection();
        if (is_null($section) || $section == 'default') {
            $event
                ->getGenerator()
                ->addUrl(
                    new UrlConcrete(
                        $this->router->generate('app_homepage', array(), UrlGeneratorInterface::ABSOLUTE_URL),
                        new \DateTime(),
                        UrlConcrete::CHANGEFREQ_HOURLY,
                        1
                    ),
                    'default'
                );
            /** @var Category $category */
            foreach ($this->categories as $category) {
                $url = $this->router->generate(
                    'app_category',
                    array(
                        'slug' => $category->getSlug(),
                    ),
                    UrlGeneratorInterface::ABSOLUTE_URL
                );
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
            }
            /** @var Film $contentPage */
            foreach ($this->contentPages as $contentPage) {
                $url = $this->router->generate(
                    'app_content',
                    array(
                        'slug' => $contentPage->getSlug(),
                    ),
                    UrlGeneratorInterface::ABSOLUTE_URL
                );
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
            }
            /** @var Page $staticPage */
            foreach ($this->staticPages as $staticPage) {
                $url = $this->router->generate(
                    'app_static_page',
                    array(
                        'slug' => $staticPage->getSlug(),
                    ),
                    UrlGeneratorInterface::ABSOLUTE_URL
                );
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
            }
        }
    }
}
