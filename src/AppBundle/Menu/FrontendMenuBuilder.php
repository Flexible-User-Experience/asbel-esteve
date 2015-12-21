<?php

namespace AppBundle\Menu;

use AppBundle\Controller\Frontend\DefaultController;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class FrontendMenuBuilder
 *
 * @category Menu
 * @package  AppBundle\Menu
 * @author   David Romaní <david@flux.cat>
 */
class FrontendMenuBuilder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return ItemInterface
     */
    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->createBottomMenu($requestStack);
        $menu->removeChild('homepage');

        return $menu;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return ItemInterface
     */
    public function createBottomMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
        $menu->addChild(
            'homepage',
            array(
                'route'   => 'homepage',
                'current' => $requestStack->getCurrentRequest()->get('_route') == DefaultController::ROUTE_HOMEPAGE,
            )
        );
        $menu->addChild(
            'films',
            array(
                'route'   => 'films',
                'current' => $requestStack->getCurrentRequest()->get('_route') == DefaultController::ROUTE_FILMS,
            )
        );
        $menu->addChild(
            'artwork',
            array(
                'route'   => 'artwork',
                'current' => $requestStack->getCurrentRequest()->get('_route') == DefaultController::ROUTE_ARTWORK,
            )
        );
        $menu->addChild(
            'words, interviews, screenings and news',
            array(
                'route'   => 'news',
                'current' => $requestStack->getCurrentRequest()->get('_route') == DefaultController::ROUTE_NEWS,
            )
        );

        return $menu;
    }
}
