<?php

namespace App\Controller;

use App\Entity\Coaster;
use App\Form\CoasterType;
use App\Repository\CategoryRepository;
use App\Repository\CoasterRepository;
use App\Repository\ParkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Func;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoasterController extends AbstractController
{
    #[Route(path: '/coaster')]
    public function index(CoasterRepository $coasterRepository, ParkRepository $parkRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        //Récupère toutes les entités Coasters
        $entities = $coasterRepository->findAll();
        $parks = $parkRepository->findAll();
        $categories = $categoryRepository->findAll();

        // valeurs envoyées  depuis le formulaire de filtre
        $parkId = (int) $request->query->get('park');
        $categiryId = (int) $request->query->get('category');


        return $this->render('coaster/index.html.twig', [
            'entities' => $entities, // Envoi des entités dans la vue
            'parks' => $parks,
            'categories' => $categories,
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

    #[route(path: '/coaster/{id<\d+>}/delete')]
    public function delete(Coaster $entity, EntityManagerInterface $em, Request $request): Response
    {
        // $_POST['_token'] => $request->request
        // $_GET['value'] => $request->http_build_query
        // $_SERVER[] => $request->$_SERVER

        if ($this->isCsrfTokenValid('delete' . $entity->getId(), $request->request->get('_token'))) {
            $em->remove($entity);
            $em->flush();
            return $this->redirect('app_coaster_delete');
        }
        return $this->render('/coaster/delete.html.twig', [
            'coaster' => $entity,
        ]);
    }
}
