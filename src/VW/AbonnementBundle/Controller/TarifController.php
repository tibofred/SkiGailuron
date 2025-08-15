<?php



namespace VW\AbonnementBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VW\AbonnementBundle\Entity\Tarif;

use VW\AbonnementBundle\Form\TarifType;

use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class TarifController extends Controller

{

    public function skiDeFondAction()

    {

        $em = $this->getDoctrine()->getManager();



        $sport = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nomEn' => 'Cross country skiing'));



        $tarifs_journaliers = $em->getRepository('VWAbonnementBundle:Tarif')->findBy(array('sport' => $sport), array('id' => 'ASC'));



        $tarifs_abonnement = $em->getRepository('VWAbonnementBundle:TypeAbonnement')

            ->findBy(array("sport" => $sport), array('id' => 'DESC'));



        return $this->render('VWAbonnementBundle:Tarif:ski-de-fond.html.twig', array(

            'tarifs_journaliers' => $tarifs_journaliers,

            'tarifs_abonnement' => $tarifs_abonnement,

        ));

    }

    

    



    public function raquetteAction()

    {

        $em = $this->getDoctrine()->getManager();



        $sport = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nomEn' => 'Snow shoes'));



        $tarifs_journaliers = $em->getRepository('VWAbonnementBundle:Tarif')->findBy(array('sport' => $sport), array('id' => 'ASC'));



        $tarifs_abonnement = $em->getRepository('VWAbonnementBundle:TypeAbonnement')

            ->findBy(array("sport" => $sport), array('id' => 'DESC'));



        return $this->render('VWAbonnementBundle:Tarif:raquette.html.twig', array(

            'tarifs_journaliers' => $tarifs_journaliers,

            'tarifs_abonnement' => $tarifs_abonnement,

        ));

    }



    public function fatbikeAction()

    {

        $em = $this->getDoctrine()->getManager();



        $sport = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nomEn' => 'Fat bike'));



        $tarifs_journaliers = $em->getRepository('VWAbonnementBundle:Tarif')->findBy(array('sport' => $sport),array('id' => 'ASC'));



        $tarifs_abonnement = $em->getRepository('VWAbonnementBundle:TypeAbonnement')

            ->findBy(array("sport" => $sport),array('id' => 'DESC'));



        return $this->render('VWAbonnementBundle:Tarif:fatbike.html.twig', array(

            'tarifs_journaliers' => $tarifs_journaliers,

            'tarifs_abonnement' => $tarifs_abonnement,

        ));

    }



    public function listeAction()

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();



        $tarifs = $em->getRepository('VWAbonnementBundle:Tarif')->findAll();



        return $this->render('VWAbonnementBundle:Tarif:liste.html.twig', array(

            'tarifs' => $tarifs,

        ));

    }





    public function nouveauAction(Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $tarif = new Tarif();

        $form = $this->get('form.factory')->create(TarifType::class, $tarif);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($tarif);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le type à bien été ajouté');

            return $this->redirectToRoute('vw_tarif_liste', array('id' => $tarif->getId()));

        }

        return $this->render('VWAbonnementBundle:Tarif:nouveau.html.twig', array(

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

        $tarif = $em->getRepository('VWAbonnementBundle:Tarif')->find($id);



        if (null === $tarif) {

            throw new NotFoundHttpException("Le Type d'abonnement d'id " . $id . " n'existe pas.");

        }



        $form = $this->get('form.factory')->create(TarifType::class, $tarif);



        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Inutile de persister ici, Doctrine connait déjà notre annonce

            $em->flush();



            $request->getSession()->getFlashBag()->add('notice', 'Le Type Abonnement à bien été modifiée.');



            $tarifs = $em->getRepository('VWAbonnementBundle:Tarif')->findAll();





            return $this->render('VWAbonnementBundle:Tarif:liste.html.twig', array(

                'tarifs' => $tarifs,

            ));

        }



        return $this->render('VWAbonnementBundle:Tarif:modifier.html.twig', array(

            'tarif' => $tarif,

            'form' => $form->createView(),

        ));

    }



    public function supprimerAction(Request $request, Tarif $tarif)

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

            $em->remove($tarif);

            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le type a bien été supprimée.");

            $tarifs = $em->getRepository('VWAbonnementBundle:Tarif')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :





            return $this->render('VWAbonnementBundle:Tarif:liste.html.twig', array(

                'tarifs' => $tarifs,

            ));

        }



        return $this->render('VWAbonnementBundle:Tarif:supprimer.html.twig', array(

            'tarif' => $tarif,

            'form' => $form->createView(),

        ));

    }

}

