<?php

declare(strict_types=1);

namespace StarWars\Controller;

use StarWars\Service\ApiConsumer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HomeController extends AbstractController
{
    private $apiConsumer;

    public function __construct(ApiConsumer $apiConsumer)
    {
        $this->apiConsumer = $apiConsumer;
    }

    public function __invoke(Request $request): Response
    {
        return $this->render('Home/index.html.twig');
    }
}