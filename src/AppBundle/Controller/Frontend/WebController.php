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
    const ROUTE_HOMEPAGE    = 'app_homepage';
    const ROUTE_CATEGORY    = 'app_category';
    const ROUTE_CONTENT     = 'app_content';
    const ROUTE_STATIC_PAGE = 'app_static_page';

    /**
     * @Route("/", name="app_homepage")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homepageAction(Request $request)
    {
        $items = $this->getDoctrine()->getRepository('AppBundle:Film')->findAllEnabledSortedByCreatedDateDescWithJoin();
        /** @var ContactMessage $contact */
        $contact = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->executeSubmittedForm($contact);
        }

        return $this->render('Frontend/homepage.html.twig', [ 'items' => $items, 'form' => $form->createView() ]);
    }

    /**
     * @Route("/category/{slug}/", name="app_category")
     *
     * @param Request $request
     * @param string  $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryAction(Request $request, $slug)
    {
        /** @var Category $category */
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->findOneBySlug($slug);
        if (!$category || !$category->getEnabled()) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $items = $this->getDoctrine()->getRepository('AppBundle:Film')->findEnabledSortedByCreatedDateDescOfCategorySlug($slug);

        /** @var ContactMessage $contact */
        $contact = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->executeSubmittedForm($contact);
        }

        return $this->render('Frontend/category.html.twig', [ 'category' => $category, 'items' => $items, 'form' => $form->createView() ]);
    }

    /**
     * @Route("/{slug}/", name="app_content")
     *
     * @param Request $request
     * @param string  $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contentAction(Request $request, $slug)
    {
        /** @var Film $film */
        $film = $this->getDoctrine()->getRepository('AppBundle:Film')->findOneBySlug($slug);
        if (!$film || !$film->getEnabled()) {
            throw $this->createNotFoundException('Unable to find Film entity.');
        }

        /** @var ContactMessage $contact */
        $contact = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->executeSubmittedForm($contact);
        }

        return $this->render('Frontend/content.html.twig', [ 'content' => $film, 'form' => $form->createView() ]);
    }

    /**
     * @Route("/page/{slug}/", name="app_static_page")
     *
     * @param Request $request
     * @param         $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function staticPageAction(Request $request, $slug)
    {
        /** @var Page $page */
        $page = $this->getDoctrine()->getRepository('AppBundle:Page')->findOneBySlug($slug);
        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        /** @var ContactMessage $contact */
        $contact = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->executeSubmittedForm($contact);
        }

        return $this->render('Frontend/static_page.html.twig', [ 'page' => $page, 'form' => $form->createView()]);
    }

    /**
     * @param ContactMessage $contact
     */
    private function executeSubmittedForm(ContactMessage $contact)
    {
        // Persist new contact message form record
        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();
        // Send notifications
        $messenger = $this->get('app.notification');
        $messenger->sendUserNotification($contact);
// TODO       $messenger->sendAdminNotification($contact);
        // Build flash message
        $this->addFlash('notice', 'frontend.form.flash.user');
    }
}
