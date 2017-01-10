<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Tag;
use AppBundle\Type\TagType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    /**
     * @Route("tag/{id}", name="show_tag")
     * @Method("GET")
     */
    public function showAction(Request $request) {
        $tag = $this->getDoctrine()
            ->getRepository('AppBundle:Tag')
            ->find($request->get('id'));

        if (!$tag) {
            throw $this->createNotFoundException(
                'No tag found for id '.$request->get('id')
            );
        }
        return new Response("Tag was found: ".$tag->getName());
    }

    /**
     * @Route("tag/", name="create_tag")
     * @Method("POST")
     */
    public function createAction(Request $request) {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);
        $validator = $this->get('validator');
        $errors = $validator->validate($tag);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
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
     * @Route("tag/", name="update_tag")
     * @Method("PUT")
     */
    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository('AppBundle:Tag')->find($request->get('id'));

        if (!$tag) {
            throw $this->createNotFoundException(
                'No tag found for id '.$request->get('id')
            );
        }

        return new Response("Tag have updated: ".$tag->getName());
    }

    /**
     * @Route("tag/{id}", name="delete_tag")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository('AppBundle:Tag')->find($request->get('id'));

        if (!$tag) {
            throw $this->createNotFoundException(
                'No tag found for id '.$request->get('id')
            );
        }

        $em->remove($tag);
        $em->flush();
        return new Response("Tag with name ".$tag->getName()." was deleted.");
    }
}
