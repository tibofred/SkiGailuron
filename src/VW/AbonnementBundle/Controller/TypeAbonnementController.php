<?php



namespace VW\AbonnementBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VW\AbonnementBundle\Entity\TypeAbonnement;

use VW\AbonnementBundle\Form\TypeAbonnementType;

use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class TypeAbonnementController extends Controller

{





    public function listeAction()

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();

        // Pour récupérer une seule annonce, on utilise la méthode find($id)

        $types = $em->getRepository('VWAbonnementBundle:TypeAbonnement')->findAll();

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

        // ou null si l'id $id n'existe pas, d'où ce if :





        return $this->render('VWAbonnementBundle:TypeAbonnement:liste.html.twig', array(

            'types' => $types,



        ));



    }





    public function nouveauAction(Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $type = new TypeAbonnement();

        $form = $this->get('form.factory')->create(TypeAbonnementType::class, $type);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($type);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le type à bien été ajouté');

            return $this->redirectToRoute('vw_type_liste', array('id' => $type->getId()));

        }

        return $this->render('VWAbonnementBundle:TypeAbonnement:nouveau.html.twig', array(

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

        $type = $em->getRepository('VWAbonnementBundle:TypeAbonnement')->find($id);



        if (null === $type) {

            throw new NotFoundHttpException("Le Type d'abonnement d'id " . $id . " n'existe pas.");

        }



        $form = $this->get('form.factory')->create(TypeAbonnementType::class, $type);



        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Inutile de persister ici, Doctrine connait déjà notre annonce

            $em->flush();



            $request->getSession()->getFlashBag()->add('notice', 'Le Type Abonnement à bien été modifiée.');



            $types = $em->getRepository('VWAbonnementBundle:TypeAbonnement')->findAll();





            return $this->render('VWAbonnementBundle:TypeAbonnement:liste.html.twig', array(

                'types' => $types,



            ));

        }



        return $this->render('VWAbonnementBundle:TypeAbonnement:modifier.html.twig', array(

            'type' => $type,

            'form' => $form->createView(),

        ));

    }



    public function supprimerAction(Request $request, TypeAbonnement $type)

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

            $em->remove($type);

            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le type a bien été supprimée.");

            $types = $em->getRepository('VWAbonnementBundle:TypeAbonnement')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :





            return $this->render('VWAbonnementBundle:TypeAbonnement:liste.html.twig', array(

                'types' => $types,



            ));

        }



        return $this->render('VWAbonnementBundle:TypeAbonnement:supprimer.html.twig', array(

            'type' => $type,

            'form' => $form->createView(),

        ));

    }

}

