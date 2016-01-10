<?php

namespace AppBundle\Menu;

use AppBundle\Controller\Frontend\WebController;
use AppBundle\Entity\Category;
use AppBundle\Entity\Page;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
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
     * @var EntityManager
     */
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
     * @param FactoryInterface   $factory
     * @param EntityManager $em
     */
    public function __construct(FactoryInterface $factory, EntityManager $em)
    {
        $this->factory = $factory;
        $this->em = $em;
        $this->categories = $this->em->getRepository('AppBundle:Category')->findAllEnabledSortedByTitle();
        $this->pages = $this->em->getRepository('AppBundle:Page')->findAllSortedByTitle();
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return ItemInterface
     */
    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->createBottomMenu($requestStack);
        $menu->removeChild($menu->getFirstChild()->getName());

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
            'go home',
            array(
                'route'   => 'homepage',
                'current' => $requestStack->getCurrentRequest()->get('_route') == WebController::ROUTE_HOMEPAGE,
            )
        );
        /** @var Category $category */
        foreach ($this->categories as $category) {
            $menu->addChild(
                $category->getTitle(),
                array(
                    'route'   => 'artwork',
//                    'current' => $requestStack->getCurrentRequest()->get('_route') == WebController::ROUTE_FILMS,
                )
            );
        }
        /** @var Page $page */
        foreach ($this->pages as $page) {
            $menu->addChild(
                $page->getTitle(),
                array(
                    'route'   => 'news',
//                    'current' => $requestStack->getCurrentRequest()->get('_route') == WebController::ROUTE_FILMS,
                )
            );
        }

        return $menu;
    }
}
