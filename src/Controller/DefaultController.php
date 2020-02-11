<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\HomePage\HomePageServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DefaultController extends AbstractController
{
    /**
     * @param HomePageServiceInterface $homePageService
     * @return Response
     *
     * @Route("/", name="home")
     */
    public function index(HomePageServiceInterface $homePageService): Response
    {
        $posts = $homePageService->getPosts();

        return $this->render('default/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}