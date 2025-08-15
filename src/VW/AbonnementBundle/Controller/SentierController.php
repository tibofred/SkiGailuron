<?php



namespace VW\AbonnementBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;

use VW\AbonnementBundle\Entity\Sentier;

use VW\AbonnementBundle\Form\SentierType;

use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class SentierController extends Controller

{

    public function conditionAction()

    {

        $em = $this->getDoctrine()->getManager();



        $sentiers = $em->getRepository('VWAbonnementBundle:Sentier')->findBy(array(), array('longueur' => 'ASC'));

        $ski_de_fond_classique = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nom' => 'Ski de fond classique'));

        $ski_de_fond_sans_patin = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nom' => 'Ski de fond sans patin'));

        $raquette = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nom' => 'Raquette'));

        $fatbike = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nom' => 'Vélo Fat bike'));



        return $this->render('VWAbonnementBundle:Sentier:condition.html.twig', array(

            'sentiers' => $sentiers,

            'ski_de_fond_classique' => $ski_de_fond_classique,

            'ski_de_fond_sans_patin' => $ski_de_fond_sans_patin,
            
            'raquette' => $raquette,
            
            'fatbike' => $fatbike,

        ));

    }



    public function listeAction()

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();

        // Pour récupérer une seule annonce, on utilise la méthode find($id)

        $sentiers = $em->getRepository('VWAbonnementBundle:Sentier')->findAll();

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

        // ou null si l'id $id n'existe pas, d'où ce if :





        return $this->render('VWAbonnementBundle:Sentier:liste.html.twig', array(

            'sentiers' => $sentiers,



        ));



    }



    public function pageAction()

    {

        $em = $this->getDoctrine()->getManager();



        $sentiers = $em->getRepository('VWAbonnementBundle:Sentier')->findBy(array(), array('longueur' => 'ASC'));

        $ski_de_fond_classique = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nom' => 'Ski de fond classique'));

        $ski_de_fond_sans_patin = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nom' => 'Ski de fond sans patin'));

        $raquette = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nomEn' => 'Snow shoes'));



        return $this->render('VWAbonnementBundle:Sentier:page.html.twig', array(

            'sentiers' => $sentiers,

            'ski_de_fond_classique' => $ski_de_fond_classique,

            'ski_de_fond_sans_patin' => $ski_de_fond_sans_patin,

            'raquette' => $raquette,

        ));



    }

    

    public function skiAction()

    {

        $em = $this->getDoctrine()->getManager();



        $sentiers = $em->getRepository('VWAbonnementBundle:Sentier')->findBy(array(), array('longueur' => 'ASC'));

        $ski_de_fond_classique = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nom' => 'Ski de fond classique'));

        $ski_de_fond_sans_patin = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nom' => 'Ski de fond sans patin'));





        return $this->render('VWAbonnementBundle:Sentier:ski.html.twig', array(

            'sentiers' => $sentiers,

            'ski_de_fond_classique' => $ski_de_fond_classique,

            'ski_de_fond_sans_patin' => $ski_de_fond_sans_patin,

            

        ));



    }

    

    public function raquetteAction()

    {

        $em = $this->getDoctrine()->getManager();



        $sentiers = $em->getRepository('VWAbonnementBundle:Sentier')->findBy(array(), array('longueur' => 'ASC'));

        $raquette = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nom' => 'Raquette'));

        




        return $this->render('VWAbonnementBundle:Sentier:raquette.html.twig', array(

            'sentiers' => $sentiers,

            'raquette' => $raquette,

          

            

        ));



    }

    

    public function fatbikeAction()

    {

        
        $em = $this->getDoctrine()->getManager();



        $sentiers = $em->getRepository('VWAbonnementBundle:Sentier')->findBy(array(), array('longueur' => 'ASC'));

        $fatbike = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nom' => 'Vélo Fat bike'));

        




        return $this->render('VWAbonnementBundle:Sentier:fatbike.html.twig', array(

            'sentiers' => $sentiers,

            'fatbike' => $fatbike,

          

            

        ));
        


    }

    

    

    public function pisteSkiDeFondAction($slug)

    {

        $em = $this->getDoctrine()->getManager();



        $ski_de_fond_classique = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nom' => 'Ski de fond classique'));

        $ski_de_fond_sans_patin = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nom' => 'Ski de fond sans patin'));

        $sentier = $em->getRepository('VWAbonnementBundle:Sentier')

            ->findOneBy(array('slug' => $slug, 'sport' => array($ski_de_fond_classique, $ski_de_fond_sans_patin)));



        //À completer



        return $this->render('VWAbonnementBundle:Sentier:skiSingle.html.twig', array(

            'sentier' => $sentier,

            

        ));

    }
    
    
    
    public function pisteFatBikeAction($slug)

    {

        $em = $this->getDoctrine()->getManager();



        $fatbike = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nom' => 'Vélo Fat bike'));


        $sentier = $em->getRepository('VWAbonnementBundle:Sentier')

            ->findOneBy(array('slug' => $slug, 'sport' => array($fatbike)));



        //À completer



        return $this->render('VWAbonnementBundle:Sentier:fatbikeSingle.html.twig', array(

            'sentier' => $sentier,

            

        ));

    }



    public function pisteRaquetteAction($slug)

    {

        $em = $this->getDoctrine()->getManager();



        $raquette = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nom' => 'Raquette'));

        $sentier = $em->getRepository('VWAbonnementBundle:Sentier')

            ->findOneBy(array('slug' => $slug, 'sport' => $raquette));



        //À completer



        return $this->render('VWAbonnementBundle:Sentier:raquetteSingle.html.twig', array(

            'sentier' => $sentier,


        ));

    }



    public function modifierAction($id, Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();

        $sentier = $em->getRepository('VWAbonnementBundle:Sentier')->find($id);



        if (null === $sentier) {

            throw new NotFoundHttpException("Le sentier d'id " . $id . " n'existe pas.");

        }



        $form = $this->get('form.factory')->create(SentierType::class, $sentier);



        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Inutile de persister ici, Doctrine connait déjà notre annonce

            $em->flush();



            $request->getSession()->getFlashBag()->add('notice', 'Le sentier à bien été modifiée.');



            $sentiers = $em->getRepository('VWAbonnementBundle:Sentier')->findAll();





            return $this->render('VWAbonnementBundle:Sentier:liste.html.twig', array(

                'sentiers' => $sentiers,



            ));

        }



        return $this->render('VWAbonnementBundle:Sentier:modifier.html.twig', array(

            'sentier' => $sentier,

            'form' => $form->createView(),

        ));

    }



    public function nouveauAction(Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $sentier = new Sentier();

        $form = $this->get('form.factory')->create(SentierType::class, $sentier);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($sentier);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le sentier à bien été ajouté');

            return $this->redirectToRoute('vw_type_liste', array('id' => $sentier->getId()));

        }

        return $this->render('VWAbonnementBundle:Sentier:nouveau.html.twig', array(

            'form' => $form->createView(),

        ));



    }



    public function supprimerAction(Request $request, Sentier $sentier)

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

            $em->remove($sentier);

            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le sentier a bien été supprimée.");

            $sentiers = $em->getRepository('VWAbonnementBundle:Sentier')->findAll();



            return $this->render('VWAbonnementBundle:Sentier:liste.html.twig', array(

                'sentiers' => $sentiers,



            ));

        }



        return $this->render('VWAbonnementBundle:Sentier:supprimer.html.twig', array(

            'sentier' => $sentier,

            'form' => $form->createView(),

        ));

    }

}

