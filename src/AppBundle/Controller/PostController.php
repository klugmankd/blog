<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Type\PostType;
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
    public function showAction(Request $request)
    {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->find($request->get('id'));
        $em = $this->getDoctrine()->getEntityManager();
        $comments = $em->getRepository('AppBundle:Comment')->getAllCommentsByPost($request->get('id'));
        return $this->render("post/post.html.twig", array(
            "post" => $post,
            "comments" => $comments
        ));
    }


    /**
     * @Route("post/", name="create_post")
     * @Method("POST")
     */
    public function createAction(Request $request) {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        $validator = $this->get('validator');
        $errors = $validator->validate($post);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            if (count($errors) > 0) {
                $errorsString = (string) $errors;
                return new Response($errorsString);
            } else return $this->redirectToRoute("homepage");
        } else return $this->render('form/form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("post/{id}", name="update_post")
     * @Method({"PUT","GET"})
     */
    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->find($request->get('id'));
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        $validator = $this->get('validator');
        $errors = $validator->validate($post);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (!empty($form->handleRequest($request))) {
                if (!empty($request->get('title'))){
                    $post->setTitle($request->get('title'));
                }
                if (!empty($request->get('description'))) {
                    $post->setDescription($request->get('description'));
                }
                if (!empty($request->get('content'))) {
                    $post->setContent($request->get('content'));
                }
                if (!empty($request->get('category'))) {
                    $post->setCategory($request->get('category'));
                }
                if (!empty($request->get('tags'))) {
                    $post->addTag($request->get('tags'));
                }
                $em->flush();
                if (count($errors) > 0) {
                    $errorsString = (string) $errors;
                    return new Response($errorsString);
                } else return $this->redirectToRoute("homepage");
            }

        } else return $this->render('form/form.html.twig', array(
            'form' => $form->createView(),
        ));
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
