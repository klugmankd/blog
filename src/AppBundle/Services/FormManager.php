<?php

namespace AppBundle\Services;

use AppBundle\Entity\Post;
use AppBundle\Form\Search\SearchType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class FormManager
{
    private $doctrine;
    private $formFactory;
    public function __construct(RegistryInterface $doctrine, FormFactoryInterface $formFactory)
    {
        $this->doctrine = $doctrine;
        $this->formFactory = $formFactory;
    }

    public function createSearchPostForm(Request $request)
    {
        $searchPostForm = $this->formFactory->create(SearchType::class);
        $searchPostForm->handleRequest($request);
        if ($searchPostForm->isSubmitted() && $searchPostForm->isValid()) {
            $data = $searchPostForm->getData();
            $posts = $this->doctrine
                ->getRepository('AppBundle:Post')
                ->search($data['text']);
            return array(
                'valid' => true,
                'posts' => $posts,
                'form' => $searchPostForm,
            );
        }
        return array(
            'valid' => null,
            'result' => null,
            'form' => $searchPostForm,
        );
    }
}