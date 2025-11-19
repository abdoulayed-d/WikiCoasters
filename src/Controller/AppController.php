<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AppController extends AbstractController
{
    #[Route(path: '/')]
    public function index(): Response
    {
        return $this->render('app\index.html.twig');
    }
}
