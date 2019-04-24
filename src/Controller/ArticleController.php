<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Membre;
use App\Form\ArticleFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    use HelperTrait;

    /**
     * Démonstration de l'ajout d'un Article avec Doctrine
     * @Route("/demo/article", name="article_demo")
     */
    public function demo()
    {
        # Création d'une Catégorie
        $categorie = new Categorie();
        $categorie->setNom("Politique");
        $categorie->setSlug("politique");

        # Création d'un Auteur ( Membre )
        $membre = new Membre();
        $membre->setPrenom("Thomas");
        $membre->setNom("CHEYLAS");
        $membre->setEmail("thomas.technews.com");
        $membre->setPassword("test");
        $membre->setRoles(['ROLE_AUTEUR']);
        $membre->setDateInscription(new \DateTime());

        # Création de l'Article
        $article = new Article();
        $article->setTitre("Notre-Dame de Paris : pourra-t-on la reconstruire en 5 ans ?")
            ->setSlug("notre-dame-de-paris-pourra-t-on-la-reconstruire-en-5-ans")
            ->setContenu("<p>Bâtie en presque 200 ans, la cathédrale Notre-Dame de Paris se prépare à un chantier pharaonique pour retrouver son éclat. Mais quand pouvoir débuter les travaux ? Pour le moment, l'heure est au diagnostic. La structure a été fragilisée par les tonnes d'eau déversée pour éteindre l'incendie. Il faudra ensuite démonter l'immense échafaudage.</p>")
            ->setFeaturedImage("19120535.jpg")
            ->setSpotlight(1)
            ->setSpecial(0)
            ->setMembre($membre)
            ->setCategorie($categorie)
            ->setDateCreation(new \DateTime());

        /*
         * Récupération du Manager de Doctrine
         * -----------------------------------
         * Le EntityManager est une classe qui sait comment persister d'autre classes. (Effectuer des opérations CRUD sur nos Entités).
         */

        $em = $this->getDoctrine()->getManager(); // Permet de récupérer le EntityManager de Doctrine.

        $em->persist($categorie); // J'enregistre dans ma base la catégorie
        $em->persist($membre); // Le membre
        $em->persist($article); // Et l'article

        $em->flush(); // J'execute le tout.

        # Retourner une réponse à la vue.
        return new Response('Nouvel Article ajouté avec ID : '
            . $article->getId() . ' et la nouvelle categorie '
            . $categorie->getNom() . ' de Auteur : '
            . $membre->getPrenom()
        );


    }

    /**
     * Formulaire pour créer un article.
     * @Route("/creer-un-article", name="article_add")
     */
    public function addArticle(Request $request)
    {
        # Création d'un nouvel article
        $article = new Article();


        # Récupération d'un Auteur (Membre)
        $membre = $this->getDoctrine()
            ->getRepository(Membre::class)
            ->find(1);

        # Affecter un Auteur à l'Article
        $article->setMembre($membre);

        # Création d'un Formulaire permettant l'ajout d'un Article.
        $form = $this->createForm(ArticleFormType::class, $article);


        # Traitement des données POST
        $form->handleRequest($request);

        # Si le formulaire est soumis et valide.
        if ($form->isSubmitted() && $form->isValid()) {
            # dump($article);

            # 1. Génération du slug
            $article->setSlug($this->slugify($article->getTitre()));

            # 2. Traitement de l'upload de l'image

            /** @var UploadedFile $file */
            $file = $article->getFeaturedImage();
            $fileName = $article->getSlug().'.'.$file->guessExtension();


            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            # Mise à jour de l'image
            $article->setFeaturedImage($fileName);


            # 3. Sauvegarde en base de donnée
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            # 4. Notification
            $this->addFlash('notice', 'Félicitations, votre article est en ligne !');

            # 5. Redirection
            return $this->redirectToRoute('default_article', ['categorie' => $article->getCategorie()->getSlug(),
                                                                    'slug' => $article->getSlug(),
                                                                     'id' => $article->getId()]);

        }


        return $this->render("article/addform.html.twig", ['form' => $form->createView()]);


    }
}




