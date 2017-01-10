<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Post;
use AppBundle\Type\PostType;
use AppBundle\Entity\User;
use AppBundle\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
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

    /**
     * @Route("registration/", name="registration")
     */
    public function regAction()
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        return $this->render('user/registration.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("new/", name="new")
     */
    public function newAction()
    {
        return $this->render('new/new.html.twig');
    }

    /**
     * @Route("addPost/", name="new_post")
     */
    public function newPostAction()
    {
        return $this->render('new/post.html.twig');
    }

    /**
     * @Route("addTag/", name="new_tag")
     */
    public function newTagAction()
    {
        return $this->render('new/tag.html.twig');
    }

    /**
     * @Route("addCategory/", name="new_category")
     */
    public function newCategoryAction()
    {
        return $this->render('new/category.html.twig');
    }

    /**
     * @Route("searchByTag/{idTag}", name="find_post")
     */
    public function findPostAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $posts = $em->getRepository('AppBundle:Post')->getPostsByTag($request->get('idTag'));
        return new Response(["posts" => $posts]);
    }
}