<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NetflixNewsController extends AbstractController
{
    /**
     * @Route("/netflix-nouveautés", name="netflix_news")
     */
    public function index()
    {
        return $this->render('netflix_news/netflix_news.html.twig');
    }
}
