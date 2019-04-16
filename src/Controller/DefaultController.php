<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     *  Page d'Accueil
     */
    public function index()
    {
        return $this->render("default/index.html.twig");
        #return new Response("<html><body><h1>Page d'Accueil</h1></body></html>");
    }

    /**
     *  Page Contact
     */
    public function contact()
    {
        return $this->render("default/contact.html.twig");
        #return new Response("<html><body><h1>Page Contact</h1></body></html>");
    }

    /**
     * Page permettant d'afficher les articles d'une catégorie
     * @Route("/categorie/{slug<[a-zA-Z0-9\-_\/]+>}",defaults={"slug"="default"}, methods={"GET"}, name="default_categorie")
     */
    public function categorie($slug)
    {
        return $this->render("default/categorie.html.twig");
        #return new Response("<html><body><h1>Page Catégorie : $slug</h1></body></html>");
    }


    /**
     * Page permettant d'afficher un article
     * @Route("/{categorie}/{slug}_{id<\d+>}.html", name="default_article")
     */
    public function article($categorie, $slug, $id)
    {
        # Exemple d'URL
        # /politique/macron-bientot-vers-une-demission_954623.html
        # /sports/le-psg-se-ridiculise-dans-le-nord_125486.html
        return $this->render("default/article.html.twig");
    }


}