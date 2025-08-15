<?php


namespace VW\AbonnementBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;

use VW\AbonnementBundle\Entity\Sentier;

use VW\AbonnementBundle\Form\CentreType;

use VW\AbonnementBundle\Form\SentierType;

use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class CentreController extends Controller

{

    public function modifierAction(Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }


        $em = $this->getDoctrine()->getManager();

        $centre = $em->getRepository('VWAbonnementBundle:Centre')->findBy(array(), null, 1, null);


        if (null === $centre) {

            throw new NotFoundHttpException("Le centre n'existe pas.");

        }


        //Ce n'est pas la plus belle solution, mais elle fera l'affaire pour l'instant

        $centre = $centre[0];


        $form = $this->get('form.factory')->create(CentreType::class, $centre);


        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // Inutile de persister ici, Doctrine connait déjà notre annonce

            $em->flush();


            $request->getSession()->getFlashBag()->add('notice', 'Le centre à bien été modifiée.');

        }


        return $this->render('VWAbonnementBundle:Centre:modifier.html.twig', array(

            'centre' => $centre,

            'form' => $form->createView(),

        ));

    }

    public function neigeAction(Request $request)

    {
        $em = $this->getDoctrine()->getManager();

        $neige = $em->getRepository('VWAbonnementBundle:Centre')->findById(1);
    }

    public function statutAction(Request $request)

    {

        $em = $this->getDoctrine()->getManager();

        $centre = $em->getRepository('VWAbonnementBundle:Centre')->findBy(array(), null, 1, null);


        if ($centre === null) {

            throw new NotFoundHttpException("Le centre n'existe pas.");

        }


        //Ce n'est pas la plus belle solution, mais elle fera l'affaire pour l'instant

        $centre = $centre[0];


        if ($centre->getStatut() === false) {

            if ($request->getLocale() == "fr") {

                return new Response("Le centre est fermé");

            } else {

                return new Response("The center is closed");

            }

        } else {

            if ($request->getLocale() == "fr") {

                return new Response("Le centre est ouvert");

            } else {

                return new Response("The center is opened");

            }

        }

    }

    public function statutheaderAction(Request $request)

    {

        $em = $this->getDoctrine()->getManager();

        $centre = $em->getRepository('VWAbonnementBundle:Centre')->findBy(array(), null, 1, null);


        if ($centre === null) {

            throw new NotFoundHttpException("Le centre n'existe pas.");

        }
        $centre = $centre[0];
        
        
        if ($request->getLocale() == "fr") {
            setlocale(LC_TIME, 'fr_FR');
        }
        
        $str_return = "<div class='head_date' style='margin-right: 20px'>".date('d F Y')."</div>";
        
        /*if($centre->getStatut() && $centre->getStatusFatbike() && $centre->getStatusRaquette()) {
            if ($request->getLocale() == "fr") {
                $str_return .= "<span class='head_date'>Le centre est ouvert</span>";
            } else {
                $str_return .= "<span class='head_date'>The center is opened</span>";
            }
        } elseif($centre->getStatut() === false && $centre->getStatusFatbike() === false && $centre->getStatusRaquette() === false) {
            if ($request->getLocale() == "fr") {
                $str_return .= "<span class='head_date'>Le centre est fermé</span>";
            } else {
                $str_return .= "<span class='head_date'>The center is closed</span>";
            }
        } else {
            if ($request->getLocale() == "fr") {
                $str_return .= "<span class='head_date'>Le centre est ouvert PARTIELLEMENT</span>";
            } else {
                $str_return .= "<span class='head_date'>The center is PARTIALLY open</span>";
            }
        }
        $str_return .= "<br/>";*/
        
        $str_return .= '<div class="ico_op"><img src="/web/images/new/ico_ski.png" alt="">';
        if ($centre->getStatut() === false) {
            if ($request->getLocale() == "fr") {
                $str_return .= '<span>Fermé</span>';
            } else {
                $str_return .= '<span>Closed</span>';
            } 
        } else {
            if ($request->getLocale() == "fr") {
                $str_return .= '<span class="i_green">Ouvert</span>';
            } else {
                $str_return .= '<span class="i_green">Open</span>';
            }    
        }
        $str_return .= "</div>";
        
        $str_return .= '<div class="ico_op"><img src="/web/images/new/ico_bike.png" alt="">';
        if ($centre->getStatusFatbike() === false) {
            if ($request->getLocale() == "fr") {
                $str_return .= '<span>Fermé</span>';
            } else {
                $str_return .= '<span>Closed</span>';
            } 
        } else {
            if ($request->getLocale() == "fr") {
                $str_return .= '<span class="i_green">Ouvert</span>';
            } else {
                $str_return .= '<span class="i_green">Open</span>';
            }    
        }
        $str_return .= "</div>";
        
        $str_return .= '<div class="ico_op"><img class="l_raq" src="/web/images/new/ico_raq.png" alt="">';
        if ($centre->getStatusRaquette() === false) {
            if ($request->getLocale() == "fr") {
                $str_return .= '<span>Fermé</span>';
            } else {
                $str_return .= '<span>Closed</span>';
            } 
        } else {
            if ($request->getLocale() == "fr") {
                $str_return .= '<span class="i_green">Ouvert</span>';
            } else {
                $str_return .= '<span class="i_green">Open</span>';
            }    
        }
        $str_return .= "</div>";
        
        return new Response($str_return);

    }

    public function statutpisteAction(Request $request)

    {

        $em = $this->getDoctrine()->getManager();

        $centre = $em->getRepository('VWAbonnementBundle:Centre')->findBy(array(), null, 1, null);


        if ($centre === null) {

            throw new NotFoundHttpException("Le centre n'existe pas.");

        }
        $centre = $centre[0];
        
        
        if ($request->getLocale() == "fr") {
            setlocale(LC_TIME, 'fr_FR');
        }
        
        $str_return = "";

        if ($centre->getStatut() === false) {
            if ($request->getLocale() == "fr") {
                $str_return .= "0 sur 6";
            } else {
                $str_return .= "0 out of 6";
            }

        } else {
            if ($request->getLocale() == "fr") {
                $str_return .= "6 sur 6";
            } else {
                $str_return .= "6 out of 6";
            }

        }
        
        return new Response($str_return);

    }


    public function precipitationAction(Request $request)

    {

        $em = $this->getDoctrine()->getManager();

        $centre = $em->getRepository('VWAbonnementBundle:Centre')->findBy(array(), null, 1, null);


        if ($centre === null) {

            throw new NotFoundHttpException("Le centre n'existe pas.");

        }


        //Ce n'est pas la plus belle solution, mais elle fera l'affaire pour l'instant

        $centre = $centre[0];

        if ($request->getLocale() == "fr") {
            setlocale(LC_TIME, 'fr_FR.utf8');
            setlocale(LC_ALL, 'fr_FR.utf8');
            $dayName = ucfirst(strftime("%A"));
            $day = ucfirst(strftime("%e", strtotime(date_format($centre->getDateNeige(), "Y-m-d"))));
            $month = strftime("%B", strtotime(date_format($centre->getDateNeige(), "Y-m-d")));
            return new Response(" Le centre à reçu {$centre->getQteNeige()} cm de neige le {$day} {$month}.");

        } else {

            setlocale(LC_TIME, 'en_CA.utf8', 'eng');
            setlocale(LC_ALL, 'en_CA.utf8', 'eng');
            $dayName = ucfirst(strftime("%A"));
            $day = ucfirst(strftime("%e", strtotime(date_format($centre->getDateNeige(), "Y-m-d"))));
            $month = strftime("%B", strtotime(date_format($centre->getDateNeige(), "Y-m-d")));
            return new Response("The center has received {$centre->getQteNeige()} cm on {$month} {$day}.");
        }

    }
    
    
    public function capaciteAction(Request $request)

    {
        $em = $this->getDoctrine()->getManager();
        $centre = $em->getRepository('VWAbonnementBundle:Centre')->findBy(array(), null, 1, null);
        $centre = $centre[0];
        $capacite =  $centre->getCapacite();
        $str = "display:none;";
        if($capacite==1) {
            $str = "";    
        }
        
        return new Response($str);
    }
    
    
    public function anneeAction(Request $request)

    {
        $em = $this->getDoctrine()->getManager();
        $centre = $em->getRepository('VWAbonnementBundle:Centre')->findBy(array(), null, 1, null);
        $centre = $centre[0];
        $annee =  $centre->getAnnee();
        return new Response($annee);
    }

}