<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{

    /**
     * @Route("category/{id}", name="show_category")
     * @Method("GET")
     */
    public function showAction(Request $request) {
        $category = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->find($request->get('id'));

        if (!$category) {
            throw $this->createNotFoundException(
                'No product found for id '.$request->get('id')
            );
        }
        return new Response("Category was found: ".$category->getName());
    }

    /**
     * @Route("category/", name="create_category")
     * @Method("POST")
     */
    public function createAction(Request $request) {
        $category = new Category();
        $category->setName($request->get('name'));
        $category->setDescription($request->get('description'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        return new Response('Saved new category with name: '.$category->getName());
    }

    /**
     * @Route("category/", name="update_category")
     * @Method("PUT")
     */
    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($request->get('id'));

        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id '.$request->get('id')
            );
        }

        return new Response("Category have updated: ".$category->getName());
    }

    /**
     * @Route("category/{id}", name="delete_category")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($request->get('id'));

        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id '.$request->get('id')
            );
        }

        $em->remove($category);
        $em->flush();
        return new Response("Category with name ".$category->getName()." was deleted.");
    }
}