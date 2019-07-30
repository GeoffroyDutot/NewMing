<?php

namespace App\Controller;

use App\Entity\Games;
use App\Repository\GamesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @var GamesRepository
     */
    private $gamesRepo;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(GamesRepository $gamesRepo, ObjectManager $em)
    {
        $this->gamesRepo = $gamesRepo;
        $this->em = $em;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(GamesRepository $gamesRepo)
    {
        return $this->render('default/index.html.twig', [
            "games" => $gamesRepo->findAll()
            ]
        );
    }

    /**
     * @Route("/scrapping", name="scrapping")
     */
    public function scrapping()
    {
        //remove all the data in the games table
        $connection = $this->em->getConnection();
        $platform   = $connection->getDatabasePlatform();
        $connection->executeUpdate($platform->getTruncateTableSQL('games', true));

        //scrape the data from IG
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

            $scrapping = new Games();
            $scrapping->setTitle($title);
            $scrapping->setPrice($price);
            $scrapping->setReleasedate($releasedate);
            $scrapping->setUrl($url);
            $this->em->persist($scrapping);
            $this->em->flush();
        }
        $client->quit();

        return $this->redirectToRoute('home');
    }
}
