<?php
namespace App\Controller;

use App\Entity\Joueur;
use App\Entity\JoueurSearch;
use App\Form\JoueurSearchType;
use App\Repository\JoueurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JoueurController extends AbstractController
{
    /**
    * @var JoueurController
    */
    private $repository;
    
    public function __construct(JoueurRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    /**
    * @Route("/acquisition", name="joueur.index")
    * @return Response
    */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new JoueurSearch();
        // Je crée le formulaire avec les attributs de recherche (niveau minimal et prix maximal)
        $form = $this->createForm(JoueurSearchType::class, $search);
        $form->handleRequest($request);

        // Je configure la pagination avec la requête findAllVisibleQuery
        $joueurs = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            // Par défaut je donnerais la page numéro 1, je veux afficher 15 'query' donc 15 joueurs par page
            $request->query->getInt('page', 1), 15
        );
        
        // Je retourne dans cette page "acquisition" (en URL) avec les paramètres que j'instancie et le formulaire que je créée
        return $this->render('joueur/index.html.twig', [
            'current_menu' => 'joueurs',
            'joueurs' => $joueurs,
            'form' =>  $form->createView()
            ]);
        }
        
        // J'ai SLUGIFIER la page show pour avoir un meilleur rendu dans mon URL et donc un meilleur référencement
        /**
        * @Route ("/biens/{slug}-{id}", name="joueur.show", requirements={"slug": "[a-z0-9\-]*"})
        * @return Response
        * @param Joueur $joueur
        */
        public function show(Joueur $joueur, string $slug): Response
        {
            // Redirection avec les paramètres Slug (id et slug)
            if ($joueur->getSlug() !== $slug){
                return $this->redirectToRoute('joueur.show', [
                    'id' => $joueur->getId(),
                    'slug' => $joueur->getSlug(),
                ], 301);
            }
            return $this->render('joueur/show.html.twig', [
                'joueur' => $joueur,
                'current_menu' => 'joueurs'
                ]);
            }
        }
        ?>