<?php



namespace VW\AbonnementBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VW\AbonnementBundle\Entity\Condition;

use VW\AbonnementBundle\Form\ConditionType;

use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class ConditionController extends Controller

{

    public function listeAction()

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();

        // Pour récupérer une seule annonce, on utilise la méthode find($id)

        $conditions = $em->getRepository('VWAbonnementBundle:Condition')->findAll();

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

        // ou null si l'id $id n'existe pas, d'où ce if :





        return $this->render('VWAbonnementBundle:Condition:liste.html.twig', array(

            'conditions' => $conditions,



        ));



    }





    public function nouveauAction(Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $condition = new Condition();

        $form = $this->get('form.factory')->create(ConditionType::class, $condition);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($condition);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le Condition à bien été ajouté');

            return $this->redirectToRoute('vw_condition_liste', array('id' => $condition->getId()));

        }

        return $this->render('VWAbonnementBundle:Condition:nouveau.html.twig', array(

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

        $condition = $em->getRepository('VWAbonnementBundle:Condition')->find($id);



        if (null === $condition) {

            throw new NotFoundHttpException("Le Condition d'id " . $id . " n'existe pas.");

        }



        $form = $this->get('form.factory')->create(ConditionType::class, $condition);



        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Inutile de persister ici, Doctrine connait déjà notre annonce

            $em->flush();



            $request->getSession()->getFlashBag()->add('notice', 'Le Condition à bien été modifiée.');



            $conditions = $em->getRepository('VWAbonnementBundle:Condition')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :





            return $this->render('VWAbonnementBundle:Condition:liste.html.twig', array(

                'conditions' => $conditions,



            ));

        }



        return $this->render('VWAbonnementBundle:Condition:modifier.html.twig', array(

            'condition' => $condition,

            'form' => $form->createView(),

        ));

    }



    public function supprimerAction(Request $request, Condition $condition)

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

            $em->remove($condition);

            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le Condition a bien été supprimée.");

            $conditions = $em->getRepository('VWAbonnementBundle:Condition')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :





            return $this->render('VWAbonnementBundle:Condition:liste.html.twig', array(

                'conditions' => $conditions,



            ));

        }



        return $this->render('VWAbonnementBundle:Condition:supprimer.html.twig', array(

            'condition' => $condition,

            'form' => $form->createView(),

        ));

    }

}

