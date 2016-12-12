<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * @Route("post/{id}", name="show_post")
     * @Method("GET")
     */
    public function showAction(Request $request) {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->find($request->get('id'));

        if (!$post) {
            throw $this->createNotFoundException(
                'No product found for id '.$request->get('id')
            );
        }
        return $this->render("post/post.html.twig", array("post" => $post));
    }

    /**
     * @Route("post/", name="create_post")
     * @Method("POST")
     */
    public function createAction(Request $request) {
        $post = new Post();
        $post->setTitle($request->get('title'));
        $post->setDescription($request->get('description'));
        $post->setContent($request->get('content'));
        $post->setTag($request->get('tag'));
        $post->setCategory($request->get('category'));
        $post->setAuthor($request->get('author'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return new Response('Saved new post with name: '.$post->getTitle());
    }

    /**
     * @Route("post/", name="update_post")
     * @Method("PUT")
     */
    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->find($request->get('id'));

        if (!$post) {
            throw $this->createNotFoundException(
                'No post found for id '.$request->get('id')
            );
        }

        return new Response("post have updated: ".$post->getName());
    }

    /**
     * @Route("post/{id}", name="delete_post")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->find($request->get('id'));

        if (!$post) {
            throw $this->createNotFoundException(
                'No post found for id '.$request->get('id')
            );
        }

        $em->remove($post);
        $em->flush();
        return new Response("Post with name ".$post->getName()." was deleted.");
    }
}
