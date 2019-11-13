<?php

namespace App\Controller;

use App\Repository\JoueurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{
    /**
    * @Route ("/", name ="home")
    * @param JoueurRepository $repository
    * @return Response
    */
    public function index(JoueurRepository $repository): Response
    {
        $joueurs = $repository->findAll();
        return $this->render('pages/home.html.twig', [
            'joueurs' => $joueurs
        ]);
    }
}
?>