<?php

namespace App\Controller;


use App\Form\SearchType;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;



use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ProduitsRepository $produitsRepository;

    public function __construct(EntityManagerInterface $entityManager, ProduitsRepository $produitsRepository)
    {
        $this->entityManager = $entityManager;
        $this->produitsRepository = $produitsRepository;
    }


    public function search(Request $request,PaginatorInterface $paginator)
{
    $form = $this->createForm(SearchType::class);
    $form->handleRequest($request);

    $results = [];

    if ($form->isSubmitted() && $form->isValid()) {
        $query = $form->getData()['query'];

        if ($query !== null) {
            $results = $this->produitsRepository->searchByTitle($query);
        }
        $pagination = $paginator->paginate(
            $results,
            $request->query->getInt('page', 1),
            20 // Number of items per page
        );
        $currentPage = 'Resultats recherche';
        return $this->render('search/results.html.twig', [
            'form' => $form->createView(),
            'results' => $results,
            'currentPage' => $currentPage,
            'results' => $pagination,
        ]);
    }

    $currentPage = 'Rechercher';
    return $this->render('search/index.html.twig', [
        'currentPage' => $currentPage,
        'form' => $form->createView(),
        'results' => $results,
       
        
    ]);
}


    /**
     * @Route("/search/results", name="search_results")
     */
    public function showResults(Request $request,PaginatorInterface $paginator)
    {
        
        $query = $request->query->get('query');
        return $this->search($request, $paginator);

        if ($query === null) {
            $results = [];
        } else {
            $results = $this->produitsRepository->searchByTitle($query);
            
        }
       
        // $pagination = $paginator->paginate(
        //     $results,
        //     $request->query->getInt('page', 1),
        //     10 // Number of items per page
        // );
        $form = $this->createForm(SearchType::class);
        $currentPage = 'Resultats recherche';
        return $this->render('search/results.html.twig', [
            'form' => $form->createView(),
            'results' => $results,
            'currentPage' => $currentPage,
         
        ]);
     
        
    }
}
