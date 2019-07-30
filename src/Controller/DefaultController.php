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
       $games = [];

       $client = \Symfony\Component\Panther\Client::createChromeClient();
       $crawler = $client->request('GET', 'https://www.instant-gaming.com/fr/rechercher/?preorder=1&sort_by=avail_date_asc');
       $fullPageHtml = $crawler->html();
       $countitem = $crawler->filter('#ig-panel-center > div.search-wrapper > div.search > div')->count();
       for($i=1; $i<$countitem+1; $i++){
           $releasedate = $crawler->filter('#ig-panel-center > div.search-wrapper > div.search > div:nth-child('.$i.') > div.name')->text();
           $title = $crawler->filter('#ig-panel-center > div.search-wrapper > div.search > div:nth-child('.$i.') > a > img')->attr('alt');
           $url = $crawler->filter('#ig-panel-center > div.search-wrapper > div.search > div:nth-child('.$i.') > a > img')->attr('src');
           $url = str_replace('157x218', '271x377', $url);
           $price = $crawler->filter('#ig-panel-center > div.search-wrapper > div.search > div:nth-child('.$i.') > a > div > div.price')->text();

           $game = [
               "title" => $title,
               "releasedate" => $releasedate,
               "url" => $url,
               "price" => $price
           ];

           $games[] = $game;
       }

        $client->quit();

        return $this->render('default/index.html.twig', [
            "games" => $games
            ]
        );
    }
}
