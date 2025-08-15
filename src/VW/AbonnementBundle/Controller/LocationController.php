<?php



namespace VW\AbonnementBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VW\AbonnementBundle\Entity\LocationSki;

use VW\AbonnementBundle\Entity\LocationRaquette;

use VW\AbonnementBundle\Entity\LocationTraineau;

use VW\AbonnementBundle\Entity\LocationFatbike;

use VW\AbonnementBundle\Form\LocationSkiType;

use VW\AbonnementBundle\Form\LocationRaquetteType;

use VW\AbonnementBundle\Form\LocationTraineauType;

use VW\AbonnementBundle\Form\LocationFatbikeType;

use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class LocationController extends Controller

{

    

    public function skiPageAction()

    {

        

        $em = $this->getDoctrine()->getManager();



        $locations = $em->getRepository('VWAbonnementBundle:LocationSki')->findBy(array(), array('id' => 'ASC'));



        return $this->render('VWAbonnementBundle:Location:skiPage.html.twig', array(

            'locations' => $locations,

        ));

    }

    

    

    public function locationAction()

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();



        $locations_ski = $em->getRepository('VWAbonnementBundle:LocationSki')->findBy(array(), array('prix' => 'ASC'));

        $locations_raquette = $em->getRepository('VWAbonnementBundle:LocationRaquette')->findAll();

        $locations_traineau = $em->getRepository('VWAbonnementBundle:LocationTraineau')->findAll();

        $locations_fatbike = $em->getRepository('VWAbonnementBundle:LocationFatbike')->findAll();



        return $this->render('VWAbonnementBundle:Location:page.html.twig', array(

            'locations_ski' => $locations_ski,

            'locations_raquette' => $locations_raquette,

            'locations_traineau' => $locations_traineau,

            'locations_fatbike' => $locations_fatbike,

        ));

    }



    public function skiListeAction()

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();



        $locations = $em->getRepository('VWAbonnementBundle:LocationSki')->findAll();



        return $this->render('VWAbonnementBundle:Location:skiListe.html.twig', array(

            'locations' => $locations,

        ));

    }







    public function skiNouveauAction(Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $location_ski = new LocationSki();

        $em = $this->getDoctrine()->getManager();



        $sport = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nomEn' => 'Cross country skiing'));

        $location_ski->setSport($sport);



        $form = $this->get('form.factory')->create(LocationSkiType::class, $location_ski);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em->persist($location_ski);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le type à bien été ajouté');

            return $this->redirectToRoute('vw_location_ski_liste', array('id' => $location_ski->getId()));

        }

        return $this->render('VWAbonnementBundle:Location:skiNouveau.html.twig', array(

            'form' => $form->createView(),

        ));



    }



    public function skiModifierAction($id, Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();

        $location_ski = $em->getRepository('VWAbonnementBundle:LocationSki')->find($id);



        if (null === $location_ski) {

            throw new NotFoundHttpException("Le Type d'abonnement d'id " . $id . " n'existe pas.");

        }



        $form = $this->get('form.factory')->create(LocationSkiType::class, $location_ski);



        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Inutile de persister ici, Doctrine connait déjà notre annonce

            $em->flush();



            $request->getSession()->getFlashBag()->add('notice', 'Le Type Abonnement à bien été modifiée.');



            $locations = $em->getRepository('VWAbonnementBundle:LocationSki')->findAll();





            return $this->render('VWAbonnementBundle:Location:skiListe.html.twig', array(

                'locations' => $locations,

            ));

        }



        return $this->render('VWAbonnementBundle:Location:skiModifier.html.twig', array(

            'location_ski' => $location_ski,

            'form' => $form->createView(),

        ));

    }



    public function skiSupprimerAction(Request $request, LocationSki $location_ski)

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

            $em->remove($location_ski);

            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le type a bien été supprimée.");

            $locations = $em->getRepository('VWAbonnementBundle:LocationSki')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :





            return $this->render('VWAbonnementBundle:Location:skiListe.html.twig', array(

                'locations' => $locations,

            ));

        }



        return $this->render('VWAbonnementBundle:Location:skiSupprimer.html.twig', array(

            'location_ski' => $location_ski,

            'form' => $form->createView(),

        ));

    }

    

     public function raquettePageAction()

    {

        

        $em = $this->getDoctrine()->getManager();



        $locations = $em->getRepository('VWAbonnementBundle:LocationRaquette')->findBy(array(), array('id' => 'ASC'));



        return $this->render('VWAbonnementBundle:Location:raquettePage.html.twig', array(

            'locations' => $locations,

        ));

    }



    public function raquetteListeAction()

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();



        $locations = $em->getRepository('VWAbonnementBundle:LocationRaquette')->findAll();



        return $this->render('VWAbonnementBundle:Location:raquetteListe.html.twig', array(

            'locations' => $locations,

        ));

    }



    public function raquetteNouveauAction(Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $location_raquette = new LocationRaquette();

        $em = $this->getDoctrine()->getManager();



        $sport = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nomEn' => 'Snow shoes'));

        $location_raquette->setSport($sport);



        $form = $this->get('form.factory')->create(LocationRaquetteType::class, $location_raquette);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em->persist($location_raquette);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le type à bien été ajouté');

            return $this->redirectToRoute('vw_location_raquette_liste', array('id' => $location_raquette->getId()));

        }

        return $this->render('VWAbonnementBundle:Location:raquetteNouveau.html.twig', array(

            'form' => $form->createView(),

        ));



    }



    public function raquetteModifierAction($id, Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();

        $location_raquette = $em->getRepository('VWAbonnementBundle:LocationRaquette')->find($id);



        if (null === $location_raquette) {

            throw new NotFoundHttpException("Le Type d'abonnement d'id " . $id . " n'existe pas.");

        }



        $form = $this->get('form.factory')->create(LocationraquetteType::class, $location_raquette);



        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Inutile de persister ici, Doctrine connait déjà notre annonce

            $em->flush();



            $request->getSession()->getFlashBag()->add('notice', 'Le Type Abonnement à bien été modifiée.');



            $locations = $em->getRepository('VWAbonnementBundle:LocationRaquette')->findAll();





            return $this->render('VWAbonnementBundle:Location:raquetteListe.html.twig', array(

                'locations' => $locations,

            ));

        }



        return $this->render('VWAbonnementBundle:Location:raquetteModifier.html.twig', array(

            'location_raquette' => $location_raquette,

            'form' => $form->createView(),

        ));

    }



    public function raquetteSupprimerAction(Request $request, LocationRaquette $location_raquette)

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

            $em->remove($location_raquette);

            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le type a bien été supprimée.");

            $locations = $em->getRepository('VWAbonnementBundle:LocationRaquette')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :





            return $this->render('VWAbonnementBundle:Location:raquetteListe.html.twig', array(

                'locations' => $locations,

            ));

        }



        return $this->render('VWAbonnementBundle:Location:raquetteSupprimer.html.twig', array(

            'location_raquette' => $location_raquette,

            'form' => $form->createView(),

        ));

    }



    public function traineauListeAction()

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();



        $locations = $em->getRepository('VWAbonnementBundle:LocationTraineau')->findAll();



        return $this->render('VWAbonnementBundle:Location:traineauListe.html.twig', array(

            'locations' => $locations,

        ));

    }



    public function traineauNouveauAction(Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $location_traineau = new LocationTraineau();

        $em = $this->getDoctrine()->getManager();



        $sport = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nomEn' => 'Snow shoes'));

        $location_traineau->setSport($sport);



        $form = $this->get('form.factory')->create(LocationTraineauType::class, $location_traineau);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em->persist($location_traineau);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le type à bien été ajouté');

            return $this->redirectToRoute('vw_location_traineau_liste', array('id' => $location_traineau->getId()));

        }

        return $this->render('VWAbonnementBundle:Location:traineauNouveau.html.twig', array(

            'form' => $form->createView(),

        ));



    }



    public function traineauModifierAction($id, Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();

        $location_traineau = $em->getRepository('VWAbonnementBundle:LocationTraineau')->find($id);



        if (null === $location_traineau) {

            throw new NotFoundHttpException("Le Type d'abonnement d'id " . $id . " n'existe pas.");

        }



        $form = $this->get('form.factory')->create(LocationTraineauType::class, $location_traineau);



        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Inutile de persister ici, Doctrine connait déjà notre annonce

            $em->flush();



            $request->getSession()->getFlashBag()->add('notice', 'Le Type Abonnement à bien été modifiée.');



            $locations = $em->getRepository('VWAbonnementBundle:LocationTraineau')->findAll();





            return $this->render('VWAbonnementBundle:Location:traineauListe.html.twig', array(

                'locations' => $locations,

            ));

        }



        return $this->render('VWAbonnementBundle:Location:traineauModifier.html.twig', array(

            'location_traineau' => $location_traineau,

            'form' => $form->createView(),

        ));

    }



    public function traineauSupprimerAction(Request $request, LocationTraineau $location_traineau)

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

            $em->remove($location_traineau);

            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le type a bien été supprimée.");

            $locations = $em->getRepository('VWAbonnementBundle:LocationTraineau')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :





            return $this->render('VWAbonnementBundle:Location:traineauListe.html.twig', array(

                'locations' => $locations,

            ));

        }



        return $this->render('VWAbonnementBundle:Location:traineauSupprimer.html.twig', array(

            'location_traineau' => $location_traineau,

            'form' => $form->createView(),

        ));

    }

    

    

    public function fatbikePageAction()

    {

        

        $em = $this->getDoctrine()->getManager();



        $locations = $em->getRepository('VWAbonnementBundle:LocationFatbike')->findBy(array('sport' => 3), array('prix' => 'ASC'));
        $locations_elect = $em->getRepository('VWAbonnementBundle:LocationFatbike')->findBy(array('sport' => 6), array('prix' => 'ASC'));



        return $this->render('VWAbonnementBundle:Location:fatbikePage.html.twig', array(

            'locations' => $locations,
            'locations_elect' => $locations_elect,

        ));

    }



    public function fatbikeListeAction()

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();



        $locations = $em->getRepository('VWAbonnementBundle:LocationFatbike')->findAll();



        return $this->render('VWAbonnementBundle:Location:fatbikeListe.html.twig', array(

            'locations' => $locations,

        ));

    }





    public function fatbikeNouveauAction(Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $location_fatbike = new LocationFatbike();

        $em = $this->getDoctrine()->getManager();



        $sport = $em->getRepository('VWAbonnementBundle:Sport')->findOneBy(array('nomEn' => 'Fat bike'));

        $location_fatbike->setSport($sport);



        $form = $this->get('form.factory')->create(LocationfatbikeType::class, $location_fatbike);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em->persist($location_fatbike);

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le type à bien été ajouté');

            return $this->redirectToRoute('vw_location_fatbike_liste', array('id' => $location_fatbike->getId()));

        }

        return $this->render('VWAbonnementBundle:Location:fatbikeNouveau.html.twig', array(

            'form' => $form->createView(),

        ));



    }



    public function fatbikeModifierAction($id, Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }



        $em = $this->getDoctrine()->getManager();

        $location_fatbike = $em->getRepository('VWAbonnementBundle:LocationFatbike')->find($id);



        if (null === $location_fatbike) {

            throw new NotFoundHttpException("Le Type d'abonnement d'id " . $id . " n'existe pas.");

        }



        $form = $this->get('form.factory')->create(LocationfatbikeType::class, $location_fatbike);



        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Inutile de persister ici, Doctrine connait déjà notre annonce

            $em->flush();



            $request->getSession()->getFlashBag()->add('notice', 'Le Type Abonnement à bien été modifiée.');



            $locations = $em->getRepository('VWAbonnementBundle:LocationFatbike')->findAll();





            return $this->render('VWAbonnementBundle:Location:fatbikeListe.html.twig', array(

                'locations' => $locations,

            ));

        }



        return $this->render('VWAbonnementBundle:Location:fatbikeModifier.html.twig', array(

            'location_fatbike' => $location_fatbike,

            'form' => $form->createView(),

        ));

    }



    public function fatbikeSupprimerAction(Request $request, LocationFatbike $location_fatbike)

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

            $em->remove($location_fatbike);

            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le type a bien été supprimée.");

            $locations = $em->getRepository('VWAbonnementBundle:LocationFatbike')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :





            return $this->render('VWAbonnementBundle:Location:fatbikeListe.html.twig', array(

                'locations' => $locations,

            ));

        }



        return $this->render('VWAbonnementBundle:Location:fatbikeSupprimer.html.twig', array(

            'location_fatbike' => $location_fatbike,

            'form' => $form->createView(),

        ));

    }

}

