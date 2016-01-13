<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Film;
use AppBundle\Menu\FrontendMenuBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Knp\Menu\MenuItem;
use Symfony\Component\HttpFoundation\RequestStack;
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

    /** @var RequestStack */
    private $rs;

    /** @var FrontendMenuBuilder */
    private $fmb;

    /** @var string */
    private $baseRoute;

    /** @var ArrayCollection  */
    private $contentPages;

    /**
     * SitemapListener constructor
     *
     * @param RouterInterface     $router
     * @param EntityManager       $em
     * @param RequestStack        $rs
     * @param FrontendMenuBuilder $fmb
     */
    public function __construct(RouterInterface $router, EntityManager $em, RequestStack $rs, FrontendMenuBuilder $fmb)
    {
        $this->router = $router;
        $this->em = $em;
        $this->rs = $rs;
        $this->fmb = $fmb;
        $this->contentPages = $this->em->getRepository('AppBundle:Film')->findAllEnabledSortedByPublishDateDescWithJoin();
//        $this->baseRoute = $this->rs->getCurrentRequest()->getSchemeAndHttpHost();
        $this->baseRoute = 'http://www.asbelesteve.com'; // TODO decouple this hardcoded route
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populateSitemap(SitemapPopulateEvent $event)
    {
        $section = $event->getSection();
        if (is_null($section) || $section == 'default') {
            $menu = $this->fmb->createMainMenu($this->rs);
            /** @var MenuItem $child */
            foreach ($menu->getChildren() as $child) {
                $event
                    ->getGenerator()
                    ->addUrl(
                        new UrlConcrete(
                            $this->baseRoute . $child->getUri(),
                            new \DateTime(),
                            UrlConcrete::CHANGEFREQ_HOURLY,
                            1
                        ),
                        'default'
                    );
            }
            /** @var Film $contentPage */
            foreach ($this->contentPages as $contentPage) {
                $url = $this->router->generate('app_content', array(
                    'slug' => $contentPage->getSlug(),
                ), UrlGeneratorInterface::ABSOLUTE_URL);
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
