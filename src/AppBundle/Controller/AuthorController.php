<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends Controller
{
    /**
     * @Route("author/{id}", name="create_author")
     */
    public function createAction(Request $request) {
        $author = new Author();
        $author->setUser('8');
        $em = $this->getDoctrine()->getManager();
        $em->persist($author);
        $em->flush();
        return new Response('User saved');
    }

    /**
     * @Route("author/{id}", name="delete_author")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $author = $em->getRepository('AppBundle:Author')->find($request->get('id'));

        if (!$author) {
            throw $this->createNotFoundException(
                'No Author found for id '.$request->get('id')
            );
        }

        $em->remove($author);
        $em->flush();
        return new Response("Author with name ".$author->getName()." was deleted.");
    }
}
