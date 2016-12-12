<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("user/{id}", name="show_user")
     * @Method("GET")
     */
    public function showAction(Request $request) {
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($request->get('id'));

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$request->get('id')
            );
        }
        return new Response("user was found: ".$user->getUsername());
    }

    /**
     * @Route("user/", name="create_user")
     * @Method("POST")
     */
    public function createAction(Request $request) {
        $user = new User();
        $user->setFirstName($request->get('firstName'));
        $user->setLastName($request->get('lastName'));
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $user->setPassword($request->get('password'));
        $user->setBirthday($request->get('birthday'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response('Saved new user with username: '.$user->getUsername());
    }

    /**
     * @Route("user/", name="update_user")
     * @Method("PUT")
     */
    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($request->get('id'));

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$request->get('id')
            );
        }

        return new Response("user have updated: ".$user->getUsername());
    }

    /**
     * @Route("user/{id}", name="delete_user")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($request->get('id'));

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$request->get('id')
            );
        }

        $em->remove($user);
        $em->flush();
        return new Response("user with name ".$user->getUsername()." was deleted.");
    }
}
