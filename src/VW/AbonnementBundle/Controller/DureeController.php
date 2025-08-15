<?php



namespace VW\AbonnementBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VW\AbonnementBundle\Entity\Duree;

use VW\AbonnementBundle\Form\DureeType;

use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class DureeController extends Controller

{





    public function listeAction()

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();

        // Pour récupérer une seule annonce, on utilise la méthode find($id)

        $durees = $em->getRepository('VWAbonnementBundle:Duree')->findAll();

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

        // ou null si l'id $id n'existe pas, d'où ce if :





        return $this->render('VWAbonnementBundle:Duree:liste.html.twig', array(

            'durees' => $durees,



        ));



    }





    public function nouveauAction(Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $duree = new Duree();

        $form = $this->get('form.factory')->create(DureeType::class, $duree);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($duree);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le Duree à bien été ajouté');

            return $this->redirectToRoute('vw_duree_liste', array('id' => $duree->getId()));

        }

        return $this->render('VWAbonnementBundle:Duree:nouveau.html.twig', array(

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

        $duree = $em->getRepository('VWAbonnementBundle:Duree')->find($id);



        if (null === $duree) {

            throw new NotFoundHttpException("Le Duree d'id " . $id . " n'existe pas.");

        }



        $form = $this->get('form.factory')->create(DureeType::class, $duree);



        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Inutile de persister ici, Doctrine connait déjà notre annonce

            $em->flush();



            $request->getSession()->getFlashBag()->add('notice', 'Le Duree à bien été modifiée.');



            $durees = $em->getRepository('VWAbonnementBundle:Duree')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :





            return $this->render('VWAbonnementBundle:Duree:liste.html.twig', array(

                'durees' => $durees,



            ));

        }



        return $this->render('VWAbonnementBundle:Duree:modifier.html.twig', array(

            'duree' => $duree,

            'form' => $form->createView(),

        ));

    }



    public function supprimerAction(Request $request, Duree $duree)

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

            $em->remove($duree);

            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le Duree a bien été supprimée.");

            $durees = $em->getRepository('VWAbonnementBundle:Duree')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :





            return $this->render('VWAbonnementBundle:Duree:liste.html.twig', array(

                'durees' => $durees,



            ));

        }



        return $this->render('VWAbonnementBundle:Duree:supprimer.html.twig', array(

            'duree' => $duree,

            'form' => $form->createView(),

        ));

    }

}

