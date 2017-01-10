<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Comment;
use AppBundle\Type\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * @Route("comment/{idPost}", name="show_comment")
     * @Method("GET")
     */
    public function showAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        $comments = $em->getRepository('AppBundle:Comment')->getAllCommentsByPost($request->get('idPost'));

        if (!$comments) {
            throw $this->createNotFoundException(
                'No product found for id '.$request->get('id')
            );
        }
        return $this->render("post/comment.html.twig", array("comments" => $comments));
    }

    /**
     * @Route("comment/", name="create_comment")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request) {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $validator = $this->get('validator');
        $errors = $validator->validate($comment);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $comment->setPost($request->get('idPost'));
            $em->persist($comment);
            $em->flush();
            if (count($errors) > 0) {
                $errorsString = (string) $errors;
                return new Response($errorsString);
            } else $this->redirect("post/".$request->get('idPost'));
        }
        return $this->render("form/form.html.twig", array(
//            "comment" => $comment,
            "form" => $form->createView()
        ));
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
