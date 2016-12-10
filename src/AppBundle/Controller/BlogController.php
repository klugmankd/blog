<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Database;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homeAction() {
//        $db = new Database();
//        return $this->render("post/posts.html.twig", array(
//            "records" => $db->selectTable($db->connectDB(), "posts")
//        ));
        return $this->render("about.html.twig");
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction() {
        return $this->render("about.html.twig");
    }

    /**
     * @Route("/search", name="search")
     */
    public function searchAction() {
        // $db = new Database();
        return $this->render("search.html.twig");
    }
}