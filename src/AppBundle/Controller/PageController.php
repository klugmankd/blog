<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    /**
     * @Route("/{page}", name="homepage", requirements={"page": "\d+"})
     */
    public function homeAction(Request $request, $page = 1)
    {
        $posts = $this->getDoctrine()
            ->getRepository("AppBundle:Post")
            ->getAllPosts();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($posts, $request->query->getInt('page', $page), 3);
        return $this->render('post/posts.html.twig', array('pagination' => $pagination));
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {
        return $this->render("about.html.twig");
    }

    /**
     * @Route("/category/{id}", name="category_post_show")
     */
    public function categoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $category = $em->getRepository('AppBundle:Category')->find($request->get('id'));
        $posts = $em->getRepository('AppBundle:Post')->getPostsByCategory($request->get('id'));
        return $this->render("post/postByCategory.html.twig", array("category" => $category, "posts" => $posts));
    }
}