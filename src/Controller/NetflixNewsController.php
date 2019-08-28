<?php

namespace App\Controller;

use App\Entity\ContentNetflix;
use App\Repository\ContentNetflixRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Platforms\Keywords\ReservedKeywordsValidator;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NetflixNewsController extends AbstractController
{
    /**
     * @var ContentNetflixRepository
     */
    private $contentNetflixRepo;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ContentNetflixRepository $contentNetflixRepo, ObjectManager $em)
    {
        $this->contentNetflixRepo = $contentNetflixRepo;
        $this->em = $em;
    }

    /**
     * @Route("/netflix-nouveautés", name="netflix_news")
     */
    public function index(ContentNetflixRepository $contentNetflixRepo)
    {
        return $this->render('netflix_news/netflix_news.html.twig', [
                "contentsnetflix" => $contentNetflixRepo->findAll()
            ]
        );
    }

    /**
     * @Route("/netflix-scrapping", name="netflix_scrapping")
     */
    public function scrapping()
    {
        try {
            //remove all the data in the games table
            $connection = $this->em->getConnection();
            $platform   = $connection->getDatabasePlatform();
            $connection->executeUpdate($platform->getTruncateTableSQL('content_netflix', true));

            //scrape the data from Flixable
            $client = \Symfony\Component\Panther\Client::createChromeClient();
            $crawler = $client->request('GET', 'https://fr.flixable.com/coming-soon/');
            $fullPageHtml = $crawler->html();
            $countrow = $crawler->filter('body > main > div > div')->count();



           // echo $countitem;
            echo $countrow;

            $releasedate = "";

            for($i=3; $i<$countrow+1; $i++){
                $class = $crawler->filter('body > main > div > div:nth-child('.$i.') > div')->attr('class');

                if($class=="col-12 mb-2"){
                    $releasedate = $crawler->filter('body > main > div > div:nth-child('.$i.') > div > h2')->text();
                }
                if ($class=="col-sm-6"){
                    $countrowimages = $crawler->filter('body > main > div > div:nth-child('.$i.') > div')->count();
                    for($j=1; $j<$countrowimages+1; $j++){
                        $title = $crawler->filter('body > main > div > div:nth-child('.$i.') > div:nth-child('.$j.') > div > picture > img')->attr('alt');
                        $urlImage = $crawler->filter('body > main > div > div:nth-child('.$i.') > div:nth-child('.$j.') > div > picture > img')->attr('src');

                        $scrapping = new ContentNetflix();
                        $scrapping->setTitle($title);
                        $scrapping->setReleasedate($releasedate);
                        $scrapping->setUrlimage($urlImage);
                        $this->em->persist($scrapping);
                        $this->em->flush();
                    }
                }

            }

            $client->quit();
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }

        return $this->redirectToRoute('netflix_news');
    }
}
