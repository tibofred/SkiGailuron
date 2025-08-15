<?php



namespace VW\AbonnementBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VW\AbonnementBundle\Entity\Categorie;

use VW\AbonnementBundle\Form\CategorieType;

use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class CategorieController extends Controller

{





    public function listeAction()

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();

        // Pour récupérer une seule annonce, on utilise la méthode find($id)

        $categories = $em->getRepository('VWAbonnementBundle:Categorie')->findAll();

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

        // ou null si l'id $id n'existe pas, d'où ce if :





        return $this->render('VWAbonnementBundle:Categorie:liste.html.twig', array(

            'categories' => $categories,



        ));



    }





    public function nouveauAction(Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $categorie = new Categorie();

        $form = $this->get('form.factory')->create(CategorieType::class, $categorie);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($categorie);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le Categorie à bien été ajouté');

            return $this->redirectToRoute('vw_categorie_liste', array('id' => $categorie->getId()));

        }

        return $this->render('VWAbonnementBundle:Categorie:nouveau.html.twig', array(

            'form' => $form->createView(),

        ));



    }



    public function modifierAction($id, Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();

        $categorie = $em->getRepository('VWAbonnementBundle:Categorie')->find($id);



        if (null === $categorie) {

            throw new NotFoundHttpException("Le Categorie d'id " . $id . " n'existe pas.");

        }



        $form = $this->get('form.factory')->create(CategorieType::class, $categorie);



        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Inutile de persister ici, Doctrine connait déjà notre annonce

            $em->flush();



            $request->getSession()->getFlashBag()->add('notice', 'Le Categorie à bien été modifiée.');



            $categories = $em->getRepository('VWAbonnementBundle:Categorie')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :





            return $this->render('VWAbonnementBundle:Categorie:liste.html.twig', array(

                'categories' => $categories,



            ));

        }



        return $this->render('VWAbonnementBundle:Categorie:modifier.html.twig', array(

            'categorie' => $categorie,

            'form' => $form->createView(),

        ));

    }



    public function supprimerAction(Request $request, Categorie $categorie)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF

        // Cela permet de protéger la suppression d'annonce contre cette faille

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em->remove($categorie);

            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le Categorie a bien été supprimée.");

            $categorie = $em->getRepository('VWAbonnementBundle:Categorie')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :





            return $this->render('VWAbonnementBundle:Categorie:liste.html.twig', array(

                'categorie' => $categorie,



            ));

        }



        return $this->render('VWAbonnementBundle:Categorie:supprimer.html.twig', array(

            'categorie' => $categorie,

            'form' => $form->createView(),

        ));

    }

}

