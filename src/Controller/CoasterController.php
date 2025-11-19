<?php

namespace App\Controller;

use App\Entity\Coaster;
use App\Form\CoasterType;
use App\Repository\CoasterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Func;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoasterController extends AbstractController
{
    #[Route(path: '/coaster')]
    public function index(CoasterRepository $coasterRepository): Response
    {
        //Récupère toutes les entités Coasters
        $entities = $coasterRepository->findAll();
        return $this->render('coaster/index.html.twig', [
            'entities' => $entities, // Envoi des entités dans la vue
        ]);
    }

    #[Route(path: '/coaster/add')]
    public function add(EntityManagerInterface $em, Request $request): Response
    {
        $coaster = new Coaster();
        $form = $this->createForm(CoasterType::class,  $coaster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($coaster);
            $em->flush();
        }
        return $this->render('/coaster/add.html.twig', ['coasterForm' => $form]);
    }

    // {id<\d+> est un param de type entier de 1 ou plusieur chiffres
    // Symfony utilise le param converter pour trouver l'entite Coaster depuis l'id
    #[route(path: '/coaster/{id<\d+>}/edit')]
    public function edit(Coaster $entity, EntityManagerInterface $em, Request $request): Response
    {
        // dump($entity);
        $form = $this->createForm(CoasterType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
        }
        return $this->render('/coaster/edit.html.twig', ['coasterForm' => $form]);
    }
}
