<?php
namespace App\Controller\Admin;

use App\Entity\Joueur;
use App\Entity\Langage;
use App\Form\JoueurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\JoueurRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;


class AdminJoueurController extends AbstractController {
    
    /**
    * @var JoueurRepository
    */
    private $repository;
    
    
    /** 
    * @var ObjectManager
    */
    private $em;
    
    
    
    public function __construct(JoueurRepository $repository, ObjectManager $em)
    {
        $this->repository =$repository;
        $this->em = $em;
    }
    
    /**
    * @Route("/admin", name ="admin.joueur.index")
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function index()
    {
        $joueurs = $this->repository->findAll();
        return $this->render('admin/joueur/index.html.twig', compact('joueurs'));
    }

  
    /**
    * @Route("/admin/joueur/{id}", name="admin.joueur.delete", methods="DELETE")
    * @param Joueur $joueur
    * @return \Symfony\Component\HttpFoundation\RedirectResponse
    */
    public function delete(Joueur $joueur, Request $request)
    {
        if($this->isCsrfTokenValid('delete'. $joueur->getId(), $request->get('_token')))
        {
        $this->em->remove($joueur);
        $this->em->flush(); 
        $this->addFlash('success', 'Bien supprimé avec succés');
        }
        return $this->redirectToRoute('admin.joueur.index');
    }
    /**
    * @Route("/admin/joueur/create", name ="admin.joueur.new")
    */
    public function new(Request $request)
    {
        
        $joueur = new Joueur();
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($joueur);
            $this->em->flush();
            $this->addFlash('success', 'Bien créé avec succés');
            return $this->redirectToRoute('admin.joueur.index');
        }
        
        return $this->render('admin/joueur/new.html.twig', [
            'joueur' => $joueur,
            'form' => $form->createView()
            ]);
        }
        
        /**
        * @Route("/admin/joueur/{id}", name="admin.joueur.edit", methods="GET|POST")
        * @param Joueur $joueur
        * @param Request $request
        * @return \Symfony\Component\HttpFoundation\Response
        */
        public function edit(Joueur $joueur, Request $request)
        {
            $form = $this->createForm(JoueurType::class, $joueur);
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid()){

                $this->em->flush();
                $this->addFlash('success', 'Bien modifié avec succés');
                return $this->redirectToRoute('admin.joueur.index');
                
            }
            
            return $this->render('admin/joueur/edit.html.twig', 
            [
                'joueur' => $joueur,
                'form' => $form->createView()
                ]);
            }
            
            
            
        }