<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MenuController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueil(): Response
    {

        return $this->render(
            'default/index.html.twig',
            []

        );
    }

    /**
     * @Route("/a-propos", name="a_propos")
     */
    public function aPropos(): Response
    {
        $currentPage = "À propos";
        $isApropos = true;
        $apropos = [
            "L'Art de la simplicité" => "/a-propos/l-art-de-la-simplicite",
            'Equipe'  => "/a-propos/equipe",
            'Qui nous sommes' => "/a-propos/qui-nous-sommes",
            'Conseils personnalisés' => "/a-propos/conseils-personalises",
            'Les projets' => "/a-propos/les-projets",
            'H2Origin' => "/a-propos/h2origin",
        ];
        return $this->render('A propos/index.html.twig', [
            'currentPage' => $currentPage,
            'isApropos' => $isApropos,
            'apropos' => $apropos,
        ]);
    }

    /**
     * @Route("/a-propos/l-art-de-la-simplicite", name="l_art_de_la_simplicite")
     */
    public function lArtDeLaSimplicite()
    {
        $currentPage = "L'Art de la simplicité";
        $isArtPage = true;
        return $this->render('A propos/Art de la simplicité/index.html.twig', [
            'currentPage' => $currentPage,
            'isArtPage' => $isArtPage,
        ]);
    }
    /**
     * @Route("/a-propos/equipe", name="equipe")
     */
    public function equipe(): Response
    {
        $currentPage = "Equipe RouenBio";
        $isEquipePage = true;
        return $this->render('A propos/Equipe/index.html.twig', [
            'currentPage' => $currentPage,
            'isEquipePage' => $isEquipePage,

        ]);
    }

    /**
     * @Route("/a-propos/qui-nous-sommes", name="qui_nous_sommes")
     */
    public function quiNousSommes(): Response
    {
        $currentPage = "Qui nous sommes";
        $isQns = true;
        return $this->render('A propos/Qui nous sommes/index.html.twig', [
            'currentPage' => $currentPage,
            'isQns' => $isQns,
        ]);
    }

    /**
     * @Route("/a-propos/conseils-personalises", name="conseils_personnalises")
     */
    public function conseilsPersonnalises()
    {
        $currentPage = "Conseils Personalisés";
        $isCons = true;
        return $this->render('A propos/Conseils personalisés/index.html.twig', [
            'currentPage' => $currentPage,
            'isCons' => $isCons,
        ]);
    }

    /**
     * @Route("a-propos/les-projets", name="les_projets")
     */
    public function lesProjets()
    {
        $currentPage = "Les projets";
        $isProjets = true;
        return $this->render('A propos/Les projets/index.html.twig', [
            'currentPage' => $currentPage,
            'isProjets' => $isProjets,
        ]);
    }

    /**
     * @Route("/a-propos/h2origin", name="h2origin")
     */
    public function h2origin()
    {
        $currentPage = "Eau osmosée Rouen Bio";
        $isH2o = true;
        return $this->render('A propos/H2Origin/index.html.twig', [
            'currentPage' => $currentPage,
            'isH2o' => $isH2o,
        ]);
    }

    /**
     * @Route("produits/nos-produits-bio", name="nos_produits_bio")
     */
    public function nosProduitsBio(): Response
    {
        $currentPage = "Nos Produits Bio";
        $isNosProduits = true;
        $nosProduits = [
            "Fruits et légumes" => "/nos-produits-bio/fruits-legumes",
            'Boissons'  => "/nos-produits-bio/boissons",
            'Produits frais' => "/nos-produits-bio/produits-frais",
            'Epiceries' => "/nos-produits-bio/epiceries",
            'Pains' => "/nos-produits-bio/pains",
            'Compléments alimentaires' => "/nos-produits-bio/complements-alimentaires",
            'Cosmétiques' => "/nos-produits-bio/cosmetiques",
            'Hygiéne' => "/nos-produits-bio/hygiene",
            'Bébé' => "/nos-produits-bio/bebe",
            'Maison et entretien' => "/nos-produits-bio/maison-et-entretien",
            'Surgelés' => "/nos-produits-bio/surgeles",
            'Cave a Vin' => "/nos-produits-bio/cave-a-vin",
        ];
        return $this->render('/Produits/Nos Produits Bio/nos_produits_bio.html.twig', [
            'currentPage' => $currentPage,
            'isNosProduits' => $isNosProduits,
            'nosProduits' => $nosProduits,
        ]);
    }
    /**
     * @Route("/nos-produits-bio/fruits-legumes", name="fruits_legumes")
     */
    // public function fruitsLegumes(Request $request,ProduitsRepository $produitsRepository, Security $Security): Response
    // {
    public function fruitsEtLegumes(Request $request, produitsRepository $produitsRepository, PaginatorInterface $paginator): Response
    {
        $query = $produitsRepository->createQueryBuilder('p')
            ->where('p.nomRayon = :rayon')
            ->setParameter('rayon', 'Fruits et légumes')
            ->getQuery();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );
        $currentPage = "Fruits et Légumes";

        return $this->render('/Produits/Nos Produits Bio/fruits_legumes.html.twig', [

            'fruitsLegumes' => $pagination,
            'currentPage' => $currentPage,
        ]);
    }



    /**
     * @Route("/nos-produits-bio/boissons", name="boissons")
     */
    public function boissons(Request $request, produitsRepository $produitsRepository, PaginatorInterface $paginator): Response
    {
        $query = $produitsRepository->createQueryBuilder('p')
            ->where('p.nomRayon = :rayon')
            ->setParameter('rayon', 'EPICERIE LIQUIDE')
            ->getQuery();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );
        $currentPage = "Boissons";
        $isBoissons = true;
        return $this->render('Produits/Nos Produits Bio/boissons.html.twig', [
            'currentPage' => $currentPage,
            'isBoissons' => $isBoissons,
            'boissons' => $pagination,
        ]);
    }
    /**
     * @Route("/nos-produits-bio/produits-frais", name="produits_frais", methods={"GET"})
     */
    public function produitsFrais(Request $request, ProduitsRepository $produitsRepository, PaginatorInterface $paginator): Response
    {
        $query = $produitsRepository->createQueryBuilder('p')
            ->where('p.nomRayon = :rayon')
            ->setParameter('rayon', 'SERVICE ARRIERE')
            ->getQuery();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );
        $currentPage = "Produits frais";
        $isProduitsFrais = true;
        $id = $request->attributes->get('id');
        $produit = $produitsRepository->find((int)$id);
        $imageProduit = str_replace("\\", "/", $this->getParameter('assets')) . "/img/imageProduits/";
        if (file_exists($imageProduit . $id . ".jpg")) {
            $urlImg = "/assets/img/imageProduits/" . $id . ".jpg";
        } else {
            $urlImg = "/assets/img/imageProduits/default.jpg";
        }

        return $this->render('Produits/Nos Produits Bio/produits_frais.html.twig', [
            'currentPage' => $currentPage,
            'isProduitsFrais' => $isProduitsFrais,
            'produitsFrais' => $pagination,
            'urlImg' => $urlImg,
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/nos-produits-bio/epiceries", name="epiceries")
     */
    public function epiceries(Request $request, produitsRepository $produitsRepository, PaginatorInterface $paginator): Response
    {
        $query = $produitsRepository->createQueryBuilder('p')
            ->where('p.nomRayon = :rayon')
            ->setParameter('rayon', 'EPICERIE')
            ->getQuery();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );
        $currentPage = "Epiceries";
        $isEpiceries = true;
        return $this->render('Produits/Nos Produits Bio/epiceries.html.twig', [
            'currentPage' => $currentPage,
            'isEpiceries' => $isEpiceries,
            'epiceries' => $pagination,
        ]);
    }

    /**
     * @Route("/nos-produits-bio/pains", name="pains")
     */
    public function pains(Request $request, produitsRepository $produitsRepository, PaginatorInterface $paginator): Response
    {
        $query = $produitsRepository->createQueryBuilder('p')
            ->where('p.nomRayon = :rayon')
            ->setParameter('rayon', 'PAINS')
            ->getQuery();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );
        $currentPage = "Pains";
        $isPains = true;
        return $this->render('Produits/Nos Produits Bio/pains.html.twig', [
            'currentPage' => $currentPage,
            'isPains' => $isPains,
            'pains' => $pagination,
        ]);
    }
    /**
     * @Route("/nos-produits-bio/complements-alimentaires", name="complements_alimentaires")
     */
    public function complementsAlimentaires(Request $request, produitsRepository $produitsRepository, PaginatorInterface $paginator): Response
    {
        $query = $produitsRepository->createQueryBuilder('p')
            ->where('p.nomRayon = :rayon')
            ->setParameter('rayon', 'BIEN ETRE')
            ->getQuery();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );
        $currentPage = "Compléments alimentaires";
        $isComplem = true;
        return $this->render('Produits/Nos Produits Bio/complements_alimentaires.html.twig', [
            'currentPage' => $currentPage,
            'isComplem' => $isComplem,
            'bienEtre' => $pagination,
        ]);
    }

    /**
     * @Route("/nos-produits-bio/cosmetiques", name="cosmetiques")
     */
    public function cosmetiques(Request $request, produitsRepository $produitsRepository, PaginatorInterface $paginator): Response
    {
        $query = $produitsRepository->createQueryBuilder('p')
            ->where('p.nomRayon = :rayon')
            ->setParameter('rayon', 'Cosmetiques')
            ->getQuery();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );
        $currentPage = "Cosmétiques";
        $isCosmetiques = true;
        return $this->render('Produits/Nos Produits Bio/cosmetiques.html.twig', [
            'currentPage' => $currentPage,
            'isCosmetiques' => $isCosmetiques,
            'cosmetiques' => $pagination,
        ]);
    }

    /**
     * @Route("/nos-produits-bio/hygiene", name="hygiene")
     */
    public function hygiene(Request $request, produitsRepository $produitsRepository, PaginatorInterface $paginator): Response
    {
        $query = $produitsRepository->createQueryBuilder('p')
            ->where('p.nomRayon = :rayon')
            ->setParameter('rayon', 'BEAUTE HYGIENE')
            ->getQuery();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );
        $currentPage = "Hygiéne";
        $isHygiene = true;
        return $this->render('Produits/Nos Produits Bio/hygiene.html.twig', [
            'currentPage' => $currentPage,
            'isHygiene' => $isHygiene,
            'hygiene' => $pagination,
        ]);
    }

    /**
     * @Route("/nos-produits-bio/bebe", name="bebe")
     */
    public function bebe(): Response
    {
        $currentPage = "Bébé";
        $isBebe = true;
        return $this->render('Produits/Nos Produits Bio/bebe.html.twig', [
            'currentPage' => $currentPage,
            'isBebe' => $isBebe,
        ]);
    }
    /**
     * @Route("/nos-produits-bio/maison-et-entretien", name="maison_et_entretien")
     */
    public function maisonEntretien(Request $request, produitsRepository $produitsRepository, PaginatorInterface $paginator): Response
    {
        $query = $produitsRepository->createQueryBuilder('p')
            ->where('p.nomRayon = :rayon')
            ->setParameter('rayon', 'UNIVERS MAISON')
            ->getQuery();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );
        $currentPage = "Maison et entretien";
        $isMaison = true;
        return $this->render('Produits/Nos Produits Bio/maison_et_entretien.html.twig', [
            'currentPage' => $currentPage,
            'isMaison' => $isMaison,
            'maison' => $pagination,
        ]);
    }
    /**
     * @Route("/nos-produits-bio/surgeles", name="surgeles")
     */
    public function surgeles(Request $request, produitsRepository $produitsRepository, PaginatorInterface $paginator): Response
    {
        $query = $produitsRepository->createQueryBuilder('p')
            ->where('p.nomRayon = :rayon')
            ->setParameter('rayon', 'SURGELE')
            ->getQuery();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );
        $currentPage = "Surgelés";
        $isSurgeles = true;
        return $this->render('Produits/Nos Produits Bio/surgeles.html.twig', [
            'currentPage' => $currentPage,
            'isSurgeles' => $isSurgeles,
            'surgeles' => $pagination,
        ]);
    }
    /**
     * @Route("/nos-produits-bio/cave-a-vin", name="cave_a_vin")
     */
    public function caveAVin(): Response
    {
        $currentPage = "Cave a Vin";
        $isCaveVin = true;
        return $this->render('Produits/Nos Produits Bio/cave_a_vin.html.twig', [
            'currentPage' => $currentPage,
            'isCaveVin' => $isCaveVin,
        ]);
    }
    /**
     * @Route("/ethique-et-mode-de-vie", name="ethique_et_mode_de_vie")
     */
    public function EthiqueEtModeDeVie(): Response
    {
        $currentPage = "Ethique et mode de vie";
        $isEmdv = true;
        $emdv = [
            "Le Vrac" => "/ethique-et-mode-de-vie/le-vrac",
            'Le Végan'  => "/ethique-et-mode-de-vie/le-vegan",
            'Sans Gluten' => "/ethique-et-mode-de-vie/sans-gluten",
            'Produits locaux' => "/ethique-et-mode-de-vie/produits-locaux",
            'Producteurs locaux' => "/ethique-et-mode-de-vie/producteurs-locaux",

        ];
        return $this->render('/Produits/Ethique et mode de vie/index.html.twig', [
            'currentPage' => $currentPage,
            'isEmdv' => $isEmdv,
            'emdv' => $emdv,
        ]);
    }
    /**
     * @Route("/ethique-et-mode-de-vie/le-vrac", name="le_vrac")
     */
    public function leVrac(Request $request, produitsRepository $produitsRepository, PaginatorInterface $paginator): Response
    {

        $query = $produitsRepository->createQueryBuilder('p')
            ->where('p.nomRayon = :rayon')
            ->setParameter('rayon', 'VRAC')
            ->getQuery();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );
        $currentPage = "Le Vrac";
        $isLeVrac = true;
        return $this->render('Produits/Ethique et mode de vie/Le Vrac/index.html.twig', [
            'currentPage' => $currentPage,
            'isLeVrac' => $isLeVrac,
            'vrac' => $pagination,
        ]);
    }
    /**
     * @Route("/ethique-et-mode-de-vie/le-vegan", name="le_vegan")
     */
    public function leVegan(): Response
    {
        $currentPage = "Le Végan";
        $isLeVegan = true;
        return $this->render('Produits/Ethique et mode de vie/Le Vegan/index.html.twig', [
            'currentPage' => $currentPage,
            'isLeVegan' => $isLeVegan,
        ]);
    }
    /**
     * @Route("/ethique-et-mode-de-vie/sans-gluten", name="sans_gluten")
     */
    public function sansGluten(): Response
    {
        $currentPage = "Sans Gluten";
        $isSansGluten = true;
        return $this->render('Produits/Ethique et mode de vie/Sans Gluten/index.html.twig', [
            'currentPage' => $currentPage,
            'isSansGluten' => $isSansGluten,
        ]);
    }
    /**
     * @Route("/ethique-et-mode-de-vie/producteurs-locaux", name="producteurs_locaux")
     */

    public function producteursLocaux(): Response
    {
        $currentPage = "Producteurs locaux";


        $jsFilePath = $this->getParameter('kernel.project_dir') . '/public/assets/js/prodLoc.js';
        $producteursLocaux = file_get_contents($jsFilePath);
        //   var_dump($producteursLocaux);
        //   die();
        return $this->render('Produits/Ethique et mode de vie/Producteurs Locaux/index.html.twig', [
            'producteursLocaux' => $producteursLocaux,

            'currentPage' => $currentPage,

        ]);
    }

    /**
     * @Route("/ethique-et-mode-de-vie/produits-locaux", name="produits_locaux")
     */
    public function produitsLocaux(): Response
    {
        $currentPage = "Produits locaux";
        $isProduitsLocaux = true;
        return $this->render('Produits/Ethique et mode de vie/Produits Locaux/index.html.twig', [
            'currentPage' => $currentPage,
            'isProduitsLocaux' => $isProduitsLocaux,
        ]);
    }

    /**
     * @Route("/Bonnes-Affaires", name="bonnes_affaires")
     */
    public function bonnesAffaires(): Response
    {
        $currentPage = "Bonnes Affaires";
        $isBonnesAffaires = true;
        $bonnesAffaires = [
            "Des Prix Au Plus Juste" => "/Bonnes-Affaires/Des-Prix-Au-Plus-Juste",


        ];
        return $this->render('Bonnes Affaires/index.html.twig', [
            'currentPage' => $currentPage,
            'isBonnesAffaires' => $isBonnesAffaires,
            'bonnesAffaires' => $bonnesAffaires,
        ]);
    }
    /**
     * @Route("Bonnes-Affaires/Des-Prix-Au-Plus-Juste", name="des_prix_au_plus_juste")
     */
    public function dexPrixAuPlusJuste(): Response
    {
        $currentPage = "Des Prix Au Plus Juste";
        $isDesPrixApj = true;
        return $this->render('Bonnes Affaires/Des prix au plus juste/index.html.twig', [
            'currentPage' => $currentPage,
            'isDesPrixApj' => $isDesPrixApj,
        ]);
    }
}
