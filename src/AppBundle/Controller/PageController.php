<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 12.12.16
 * Time: 18:19
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homeAction() {
        $posts = $this->getDoctrine()
            ->getRepository("AppBundle:Post")
            ->findAll();
        return $this->render("post/posts.html.twig", array(
            "records" => $posts
        ));
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction() {
        return $this->render("about.html.twig");
    }
}