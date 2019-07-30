<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $gta = [
            "title" => "GTA 6",
            "releasedate" => "27 septembre 2019",
            "url" => "https://s1.gaming-cdn.com/images/products/840/271x377/cyberpunk-2077-cover.jpg",
            "price" => "10 $"
        ];

        $minecraft = [
            "title" => "minecraft",
            "releasedate" => "30 septembre 2019",
            "url" => "https://s3.gaming-cdn.com/images/products/2669/271x377/doom-eternal-cover.jpg",
            "price" => "20 $"
        ];

        $factorio = [
            "title" => "factorio",
            "releasedate" => "31 septembre 2019",
            "url" => "https://s2.gaming-cdn.com/images/products/709/271x377/borderlands-3-cover.jpg",
            "price" => "100 $"
        ];

        $games = [$gta, $minecraft, $factorio];

        return $this->render('default/index.html.twig', [
            "games" => $games
            ]
            );
    }
}
