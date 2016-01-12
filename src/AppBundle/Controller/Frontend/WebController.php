<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Category;
use AppBundle\Entity\ContactMessage;
use AppBundle\Entity\Film;
use AppBundle\Entity\Page;
use AppBundle\Form\Type\ContactMessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class WebController
 *
 * @category Controller
 * @package  AppBundle\Controller\Frontend
 * @author   David Romaní <david@flux.cat>
 */
class WebController extends Controller
{
    const ROUTE_HOMEPAGE = 'app_homepage';
    const ROUTE_CATEGORY = 'app_category';
    const ROUTE_CONTENT = 'app_content';
    const ROUTE_STATIC_PAGE = 'app_static_page';

    /**
     * @Route("/", name="app_homepage")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homepageAction()
    {
        $items = $this->getDoctrine()->getRepository('AppBundle:Film')->findAllEnabledSortedByCreatedDateDescWithJoin();

        return $this->render('Frontend/homepage.html.twig', ['items' => $items]);
    }

    /**
     * @Route("/category/{slug}/", name="app_category")
     *
     * @param string $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryAction($slug)
    {
        /** @var Category $category */
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->findOneBy(
            array(
                'slug' => $slug,
            )
        );
        if (!$category || !$category->getEnabled()) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $items = $this->getDoctrine()->getRepository(
            'AppBundle:Film'
        )->findEnabledSortedByCreatedDateDescOfCategorySlug($slug);

        return $this->render('Frontend/category.html.twig', ['category' => $category, 'items' => $items]);
    }

    /**
     * @Route("/{slug}/", name="app_content")
     *
     * @param string $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contentAction($slug)
    {
        /** @var Film $film */
        $film = $this->getDoctrine()->getRepository('AppBundle:Film')->findOneBy(
            array(
                'slug' => $slug,
            )
        );
        if (!$film || !$film->getEnabled()) {
            throw $this->createNotFoundException('Unable to find Film entity.');
        }

        return $this->render('Frontend/content.html.twig', ['content' => $film]);
    }

    /**
     * @Route("/page/{slug}/", name="app_static_page")
     *
     * @param string $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function staticPageAction($slug)
    {
        /** @var Page $page */
        $page = $this->getDoctrine()->getRepository('AppBundle:Page')->findOneBy(array(
            'slug' => $slug,
        ));
        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        return $this->render('Frontend/static_page.html.twig', ['page' => $page]);
    }

    /**
     * @Route("/contact-form/", name="app_contact_form")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactFormAction(Request $request)
    {
        /** @var ContactMessage $contact */
        $contact = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            // Send notifications
            $messenger = $this->get('app.notification');
            $messenger->sendUserNotification($contact);
            $messenger->sendAdminNotification($contact);
            // Build flash message
            $this->addFlash('notice', 'frontend.form.flash.user');
            // Reset form
            $contact = new ContactMessage();
            $form = $this->createForm(ContactMessageType::class, $contact);
        }

        return $this->render('Frontend/contact_form.html.twig', ['form' => $form->createView()]);
    }
}
