<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * @Route("comment/{id}", name="show_comment")
     * @Method("GET")
     */
    public function showAction(Request $request) {
        $comment = $this->getDoctrine()
            ->getRepository('AppBundle:Comment')
            ->find($request->get('id'));

        if (!$comment) {
            throw $this->createNotFoundException(
                'No product found for id '.$request->get('id')
            );
        }
        return new Response("Comment was found: ".$comment->getName());
    }

    /**
     * @Route("comment/", name="create_comment")
     * @Method("POST")
     */
    public function createAction(Request $request) {
        $comment = new Comment();
        $comment->setUser($request->get('user'));
        $comment->setContent($request->get('content'));
        $comment->setCreateDate($request->get('date'));
        $comment->setPost($request->get('post'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        return new Response('Saved new Comment with name: '.$comment->getContent());
    }

    /**
     * @Route("comment/", name="update_comment")
     * @Method("PUT")
     */
    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('AppBundle:Comment')->find($request->get('id'));

        if (!$comment) {
            throw $this->createNotFoundException(
                'No Comment found for id '.$request->get('id')
            );
        }

        return new Response("Comment have updated: ".$comment->getName());
    }

    /**
     * @Route("comment/{id}", name="delete_comment")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('AppBundle:Comment')->find($request->get('id'));

        if (!$comment) {
            throw $this->createNotFoundException(
                'No Comment found for id '.$request->get('id')
            );
        }

        $em->remove($comment);
        $em->flush();
        return new Response("Comment with name ".$comment->getName()." was deleted.");
    }
}
