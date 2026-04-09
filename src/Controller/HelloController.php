<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Tmp;
use Doctrine\ORM\EntityManagerInterface;


class HelloController extends AbstractController
{
    #[Route('/hello', name: 'hello')]

    //public function index(): Response
    //{
    //    return $this->render('hello/index.html.twig', [
    //        'message' => 'Hello World!'
    //    ]);
    //}

    public function index(EntityManagerInterface $em): Response
    {
        $data = $em->getRepository(Tmp::class)->findAll();

        return $this->render('hello/index.html.twig', [
            'data' => $data
        ]);
    }

}
