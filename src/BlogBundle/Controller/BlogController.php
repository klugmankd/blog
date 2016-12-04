<?php

namespace BlogBundle\Controller;


use BlogBundle\Entity\Database;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homeAction() {
        $db = new Database();
        return $this->render("post/posts.html.twig", array(
            "records" => $db->selectTable($db->connectDB(), "posts")
        ));
    }
}