<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Category;
use AppBundle\Entity\ContactMessage;
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
    const ROUTE_HOMEPAGE = 'homepage';
    const ROUTE_FILMS = 'films';
    const ROUTE_ARTWORK = 'artwork';
    const ROUTE_NEWS = 'news';

    /**
     * @Route("/", name="app_homepage")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homepageAction(Request $request)
    {
        $items = $this->getDoctrine()->getRepository('AppBundle:Film')->findAllEnabledSortedByCreatedDateDesc();
        /** @var ContactMessage $contact */
        $contact = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // persist new contact message record
            $contact->setDescription('');
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            // add view flash message
            $this->addFlash('notice', 'frontend.index.main.sent');
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
            // persist new contact message record
            $contact->setDescription('');
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            // add view flash message
            $this->addFlash('notice', 'frontend.index.main.sent');
        }

        return $this->render('Frontend/category.html.twig', [ 'category' => $category, 'items' => $items, 'form' => $form->createView() ]);
    }

    /**
     * @Route("/news", name="news")
     */
    public function newsAction()
    {
        return $this->render('Frontend/news.html.twig');
    }
}
