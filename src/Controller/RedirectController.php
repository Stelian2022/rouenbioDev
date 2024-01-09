<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirectController extends AbstractController
{
    /**
     * @Route("/redirect-old-url", name="redirect_old_url")
     */
    public function redirectOldUrl(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('boissons', [], Response::HTTP_MOVED_PERMANENTLY);
    }
      /**
     * @Route("/redirect-old-url2", name="redirect_old_url2")
     */
    public function redirectOldUrl2(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('fruits_legumes', [], Response::HTTP_MOVED_PERMANENTLY);
    }
       /**
     * @Route("/redirect-old-url3", name="redirect_old_url3")
     */
    public function redirectOldUrl3(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('produits_frais', [], Response::HTTP_MOVED_PERMANENTLY);
    }
       /**
     * @Route("/redirect-old-url4", name="redirect_old_url4")
     */
    public function redirectOldUrl4(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('epiceries', [], Response::HTTP_MOVED_PERMANENTLY);
    }
       /**
     * @Route("/redirect-old-url5", name="redirect_old_url5")
     */
    public function redirectOldUrl5(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('pains', [], Response::HTTP_MOVED_PERMANENTLY);
    }
       /**
     * @Route("/redirect-old-url6", name="redirect_old_url6")
     */
    public function redirectOldUrl6(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('complements_alimentaires', [], Response::HTTP_MOVED_PERMANENTLY);
    }
        /**
     * @Route("/redirect-old-url7", name="redirect_old_url7")
     */
    public function redirectOldUrl7(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('cosmetiques', [], Response::HTTP_MOVED_PERMANENTLY);
    }
     /**
     * @Route("/redirect-old-url8", name="redirect_old_url8")
     */
    public function redirectOldUrl8(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('hygiene', [], Response::HTTP_MOVED_PERMANENTLY);
    }
    /**
     * @Route("/redirect-old-url9", name="redirect_old_url9")
     */
    public function redirectOldUrl9(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('bebe', [], Response::HTTP_MOVED_PERMANENTLY);
    }
    /**
     * @Route("/redirect-old-url10", name="redirect_old_url10")
     */
    public function redirectOldUrl10(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('maison_et_entretien', [], Response::HTTP_MOVED_PERMANENTLY);
    }
     /**
     * @Route("/redirect-old-url11", name="redirect_old_url11")
     */
    public function redirectOldUrl11(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('surgeles', [], Response::HTTP_MOVED_PERMANENTLY);
    }
    /**
     * @Route("/redirect-old-url12", name="redirect_old_url12")
     */
    public function redirectOldUrl12(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('cave_a_vin', [], Response::HTTP_MOVED_PERMANENTLY);
    }
      /**
     * @Route("/redirect-old-url13", name="redirect_old_url13")
     */
    public function redirectOldUrl13(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('le_vrac', [], Response::HTTP_MOVED_PERMANENTLY);
    }
      /**
     * @Route("/redirect-old-url14", name="redirect_old_url14")
     */
    public function redirectOldUrl14(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('le_vegan', [], Response::HTTP_MOVED_PERMANENTLY);
    }
     /**
     * @Route("/redirect-old-url15", name="redirect_old_url15")
     */
    public function redirectOldUrl15(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('sans_gluten', [], Response::HTTP_MOVED_PERMANENTLY);
    }
     /**
     * @Route("/redirect-old-url16", name="redirect_old_url16")
     */
    public function redirectOldUrl16(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('produits_locaux', [], Response::HTTP_MOVED_PERMANENTLY);
    }
     /**
     * @Route("/redirect-old-url17", name="redirect_old_url17")
     */
    public function redirectOldUrl17(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('producteurs_locaux', [], Response::HTTP_MOVED_PERMANENTLY);
    }
    /**
     * @Route("/redirect-old-url18", name="redirect_old_url18")
     */
    public function redirectOldUrl18(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('equipe', [], Response::HTTP_MOVED_PERMANENTLY);
    }
    /**
     * @Route("/redirect-old-url19", name="redirect_old_url19")
     */
    public function redirectOldUrl19(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('l_art_de_la_simplicite', [], Response::HTTP_MOVED_PERMANENTLY);
    }
    /**
     * @Route("/redirect-old-url20", name="redirect_old_url20")
     */
    public function redirectOldUrl20(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('qui_nous_sommes', [], Response::HTTP_MOVED_PERMANENTLY);
    }
    /**
     * @Route("/redirect-old-url21", name="redirect_old_url21")
     */
    public function redirectOldUrl21(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('conseils_personnalises', [], Response::HTTP_MOVED_PERMANENTLY);
    }
    /**
     * @Route("/redirect-old-url22", name="redirect_old_url22")
     */
    public function redirectOldUrl22(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('les_projets', [], Response::HTTP_MOVED_PERMANENTLY);
    }
    /**
     * @Route("/redirect-old-url23", name="redirect_old_url23")
     */
    public function redirectOldUrl23(): RedirectResponse
    {
        // Redirection permanente vers la nouvelle URL
        return $this->redirectToRoute('h2origin', [], Response::HTTP_MOVED_PERMANENTLY);
    }
    
}