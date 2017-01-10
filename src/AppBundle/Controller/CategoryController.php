<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Type\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{

    /**
     * @Route("category/", name="categories")
     */
    public function showAction(Request $request) {
        $category = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();
        if (!$category) {
            throw $this->createNotFoundException(
                'No product found for id '.$request->get('id')
            );
        }
        return $this->render("post/categories.html.twig", array("categories" => $category));
    }

    /**
     * @Route("category/", name="create_category")
     * @Method("POST")
     */
    public function createAction(Request $request) {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        $validator = $this->get('validator');
        $errors = $validator->validate($category);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            if (count($errors) > 0) {
                $errorsString = (string) $errors;
                return new Response($errorsString);
            } else return $this->redirectToRoute("new_category");
        } else return $this->render('form/form.html.twig', array(
            'form' => $form->createView(),
        ));
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