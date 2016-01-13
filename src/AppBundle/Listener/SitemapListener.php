<?php

namespace AppBundle\Listener;

use AppBundle\Menu\FrontendMenuBuilder;
use Knp\Menu\MenuItem;
use Symfony\Component\HttpFoundation\RequestStack;
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
    /** @var RequestStack */
    private $rs;

    /** @var FrontendMenuBuilder */
    private $fmb;

    /** @var string */
    private $baseRoute;

    /**
     * SitemapListener constructor
     *
     * @param RequestStack        $rs
     * @param FrontendMenuBuilder $fmb
     */
    public function __construct(RequestStack $rs, FrontendMenuBuilder $fmb)
    {
        $this->rs = $rs;
        $this->fmb = $fmb;
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
        }
    }
}
