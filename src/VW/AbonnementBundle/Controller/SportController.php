<?php



namespace VW\AbonnementBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VW\AbonnementBundle\Entity\Sport;

use VW\AbonnementBundle\Form\SportType;

use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class SportController extends Controller

{





    public function listeAction()

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();

        $sports = $em->getRepository('VWAbonnementBundle:Sport')->findAll();



        return $this->render('VWAbonnementBundle:Sport:liste.html.twig', array(

            'sports' => $sports,



        ));

    }





    public function nouveauAction(Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $sport = new Sport();

        $form = $this->get('form.factory')->create(SportType::class, $sport);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($sport);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le sport à bien été ajouté');

            return $this->redirectToRoute('vw_sport_liste', array('id' => $sport->getId()));

        }

        return $this->render('VWAbonnementBundle:Sport:nouveau.html.twig', array(

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

        $sport = $em->getRepository('VWAbonnementBundle:Sport')->find($id);



        if (null === $sport) {

            throw new NotFoundHttpException("Le sport d'id " . $id . " n'existe pas.");

        }



        $form = $this->get('form.factory')->create(SportType::class, $sport);



        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Inutile de persister ici, Doctrine connait déjà notre annonce

            $em->flush();



            $request->getSession()->getFlashBag()->add('notice', 'Le sport à bien été modifiée.');



            $sports = $em->getRepository('VWAbonnementBundle:Sport')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :





            return $this->render('VWAbonnementBundle:Sport:liste.html.twig', array(

                'sports' => $sports,



            ));

        }



        return $this->render('VWAbonnementBundle:Sport:modifier.html.twig', array(

            'sport' => $sport,

            'form' => $form->createView(),

        ));

    }



    public function supprimerAction(Request $request, Sport $sport)

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

            $em->remove($sport);

            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le sport a bien été supprimée.");

            $sports = $em->getRepository('VWAbonnementBundle:Sport')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :





            return $this->render('VWAbonnementBundle:Sport:liste.html.twig', array(

                'sports' => $sports,



            ));

        }



        return $this->render('VWAbonnementBundle:Sport:supprimer.html.twig', array(

            'sport' => $sport,

            'form' => $form->createView(),

        ));

    }

}

