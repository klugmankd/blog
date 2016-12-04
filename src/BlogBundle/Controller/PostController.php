<?php

namespace BlogBundle\Controller;


use BlogBundle\Entity\Database;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class PostController extends Controller
{

    /**
     * Matches /posts/*
     *
     * @Route("/posts/{id}", name="show_post")
     * @Method("GET")
     */
    public function showAction(Request $request) {
        $db = new Database();
        $post = $db->selectRecordById($db->connectDB(), "posts", $request->get('id'));
        return $this->render("post/post.html.twig", array("post" => $post));
    }
}