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
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

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
     * @var AuthorizationChecker
     */
    private $ac;

    /**
     * @var ArrayCollection all categories enabled sorted by title
     */
    private $categories;

    /**
     * @var ArrayCollection all static pages sorted by title
     */
    private $pages;

    /**
     * @param FactoryInterface     $factory
     * @param EntityManager        $em
     * @param AuthorizationChecker $ac
     */
    public function __construct(FactoryInterface $factory, EntityManager $em, AuthorizationChecker $ac)
    {
        $this->factory = $factory;
        $this->em = $em;
        $this->ac = $ac;
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
        $menu->removeChild(WebController::ROUTE_HOMEPAGE);

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
        $menu->setChildrenAttribute('class', 'my-menu list-unstyled');
        if ($this->ac->isGranted('ROLE_CMS')) {
            $menu->addChild(
                'admin',
                array(
                    'label' => '[ go admin dashboard ]',
                    'route' => 'sonata_admin_dashboard',
                )
            );
        }
        $menu->addChild(
            WebController::ROUTE_HOMEPAGE,
            array(
                'label'   => 'go home',
                'route'   => WebController::ROUTE_HOMEPAGE,
                'current' => $requestStack->getCurrentRequest()->get('_route') == WebController::ROUTE_HOMEPAGE,
            )
        );
        /** @var Category $category */
        foreach ($this->categories as $category) {
            $menu->addChild(
                $category->getSlug(),
                array(
                    'label'           => $category->getTitle(),
                    'route'           => WebController::ROUTE_CATEGORY,
                    'routeParameters' => array(
                        'slug' => $category->getSlug(),
                    ),
                    'current'         => $requestStack->getCurrentRequest()->get(
                            '_route'
                        ) == WebController::ROUTE_CATEGORY,
                )
            );
        }
        /** @var Page $page */
        foreach ($this->pages as $page) {
            $menu->addChild(
                $page->getSlug(),
                array(
                    'label'           => $page->getTitle(),
                    'route'           => WebController::ROUTE_STATIC_PAGE,
                    'routeParameters' => array(
                        'slug' => $page->getSlug(),
                    ),
                    'current'         => $requestStack->getCurrentRequest()->get(
                            '_route'
                        ) == WebController::ROUTE_STATIC_PAGE,
                )
            );
        }

        return $menu;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return ItemInterface
     */
    public function createSocialNetworksMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'my-menu list-unstyled');
        $menu
            ->addChild(
                'facebook',
                array(
                    'label' => 'facebook',
                    'uri'   => 'https://www.facebook.com/asbelesteve',
                )
            );
        $menu
            ->addChild(
                'vimeo',
                array(
                    'label' => 'vimeo',
                    'uri'   => 'https://vimeo.com/asbelesteve',
                )
            );

        return $menu;
    }
}
