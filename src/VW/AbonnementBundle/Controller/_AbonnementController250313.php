<?php


namespace VW\AbonnementBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VW\AbonnementBundle\Entity\Abonnement;

use VW\AbonnementBundle\Form\AbonnementType;

use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Payum\Core\Request\GetHumanStatus;


class AbonnementController extends Controller

{

    public function adminAction()

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }


        return $this->render('VWAbonnementBundle:Admin:index.html.twig');

    }


    public function nouveauAction(Request $request)

    {

        $em = $this->getDoctrine()->getManager();

        $abonnement = new Abonnement();

        $types_abonnements = $em->getRepository('VWAbonnementBundle:TypeAbonnement')->findAll();

        $form = $this->get('form.factory')->create(AbonnementType::class, $abonnement);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {


            $prix_total = 0.00;

            $description = "";


            //Le script met null pour une raison inconnu, alors un petit fix pour set l'abonnement manuellement

            foreach ($abonnement->getPasse() as $key => $passe) {

                $passe->setAbonnement($abonnement);

            }


            //On vérifie si le client existe déjà pour ne pas faire de duplicate

            $client = $em->getRepository('VWClientBundle:Client')
                ->findOneBy(array('courriel' => $abonnement->getClient()->getCourriel()));


            if ($client != null) {

                $abonnement->setClient($client);

            }


            //Pour chaque passe

            foreach ($abonnement->getPasse() as $passe) {

                //On récupère le type d'abonnement

                $type_abonnement = $passe->getType();

                $prix_total += $type_abonnement->getPrix();


                $description .= "{$type_abonnement->getSport()->getNom()} - {$type_abonnement->getCategorie()->getNom()}\n";

            }


            //Persists l'abonnement dans la base de données

            $em->persist($abonnement);

            $em->flush();


            //Préparation pour le paiement

            $storage = $this->get('payum')->getStorage('PaymentBundle\Entity\Payment');


            $payment = $storage->create();

            $payment->setNumber(uniqid());

            $payment->setCurrencyCode('CAD');

            /**
             * Applique un rabais de 10% du 18 au 19 novembre
             */

            //$prix_total = $prix_total - ($prix_total*0.1);

            $payment->setTotalAmount($prix_total * 100); //*100 c'est comme ça que paypal fonctionne...


            $payment->setDescription($description);

            $payment->setClientId($abonnement->getClient()->getId());

            $payment->setClientEmail($abonnement->getClient()->getCourriel());


            //Enregistrement de l'id de l'abonnement dans le paiement pour faire le mapping plus tard

            $payment->setDetails([

                'ABONNEMENT' => $abonnement->getId()

            ]);


            $storage->update($payment);


            $captureToken = $this->get('payum')->getTokenFactory()->createCaptureToken(

                "paypal_express_checkout_and_doctrine_orm",

                $payment,

                'vw_abonnement_paid' // the route to redirect after capture

            );


            //Redirige sur le site de paypal pour effectuer le paiement

            return $this->redirect($captureToken->getTargetUrl());

        }

        return $this->render('VWAbonnementBundle:Abonnement:nouveau.html.twig', array(

            'form' => $form->createView(),

            'types_abonnements' => $types_abonnements

        ));


    }
    public function paidtestAction(Request $request) {
        $mailer = $this->get('mailer');
        $em = $this->getDoctrine()->getManager();
        
        $abonnement_id = 3799;
        $paiment_id = 3723;        
        
        $abonnement = $em->getRepository('VWAbonnementBundle:Abonnement')
                ->findOneBy(array('id' => $abonnement_id));
                
                
        /*$message_client = \Swift_Message::newInstance()
            ->setSubject('Confirmation de commande Ski Gai-luron')
            ->setFrom('info@skigailuron.ca')
            ->setTo('hicham@viweb.ca')
            ->setBody(

                $this->renderView(

                    'VWAbonnementBundle:Abonnement/Email:confirmation_clienttest.html.twig',

                    array(

                        'abonnement' => $abonnement,

                        'payment' => "",

                        'token' => ""

                    )

                ),

                'text/html'

            );*/
        //$mailer->send($message_client);    
        return $this->render('VWAbonnementBundle:Abonnement/Email:confirmation_clienttest.html.twig',

                    array(

                        'abonnement' => $abonnement,

                        'payment' => "",

                        'token' => ""

                    ));
        
        //return new Response('<html><body>Hello ----!</body></html>');    
    }

    public function paidAction(Request $request)

    {

        $mailer = $this->get('mailer');


        $token = $this->get('payum')->getHttpRequestVerifier()->verify($request);


        $gateway = $this->get('payum')->getGateway($token->getGatewayName());

        $gateway->execute($status = new GetHumanStatus($token));

        $payment = $status->getFirstModel();


        //La transaction s'est effectuée correctement et paypal nous a donné un numéro de transaction

        if (isset($payment->getDetails()['TRANSACTIONID'])) {

            $payment->setNumber($payment->getDetails()['TRANSACTIONID']);


            $abonnement_id = $payment->getDetails()['ABONNEMENT'];


            $em = $this->getDoctrine()->getManager();


            $abonnement = $em->getRepository('VWAbonnementBundle:Abonnement')
                ->findOneBy(array('id' => $abonnement_id));


            //Si l'abonnement est trouvé est base de données

            if ($abonnement != null) {

                $payment->setAbonnement($abonnement);

                $em->persist($abonnement);

                $em->persist($payment);

                $em->flush();


                $message_client = \Swift_Message::newInstance()
                    ->setSubject('Confirmation de commande Ski Gai-luron')
                    ->setFrom('info@skigailuron.ca')
                    ->setTo($abonnement->getClient()->getCourriel())
                    ->setBody(

                        $this->renderView(

                            'VWAbonnementBundle:Abonnement/Email:confirmation_client.html.twig',

                            array(

                                'abonnement' => $abonnement,

                                'payment' => $payment,

                                'token' => $token

                            )

                        ),

                        'text/html'

                    );

                $message_centre = \Swift_Message::newInstance()
                    ->setSubject('Nouvel abonnement')
                    ->setFrom('info@skigailuron.ca')
                    ->setTo('info@skigailuron.ca')//À changer avant la mise en prod : info@skigailuron.ca

                    ->setBody(

                        $this->renderView(

                            'VWAbonnementBundle:Abonnement/Email:confirmation_centre.html.twig',

                            array(

                                'abonnement' => $abonnement,

                                'payment' => $payment,

                                'token' => $token

                            )

                        ),

                        'text/html'

                    );


                $mailer->send($message_client);

                $mailer->send($message_centre);

            }


            return $this->redirectToRoute('vw_abonnement_voir', array('token' => $token->getHash()));


        } else {

            //La transaction ne s'est pas effectuée correctement

            //Le client n'a pas été chargé


            $abonnement_id = $payment->getDetails()['ABONNEMENT'];


            $em = $this->getDoctrine()->getManager();


            $abonnement = $em->getRepository('VWAbonnementBundle:Abonnement')
                ->findOneBy(array('id' => $abonnement_id));


            //Si l'abonnement est trouvé est base de données

            if ($abonnement != null) {

                $payment->setAbonnement($abonnement);

                $em->persist($abonnement);

                $em->persist($payment);

                $em->flush();

            }


            //Ici, envoyer le courriel d'annulation de la commande

            return $this->render('VWAbonnementBundle:Abonnement:annule.html.twig', array(

                'abonnement' => $abonnement,

                'payment' => $payment

            ));

        }


    }


    public function listeAction(Request $request)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }


        $em = $this->getDoctrine()->getManager();

        $abonnements = $em->getRepository('VWAbonnementBundle:Abonnement')
            ->findBy(

                array(), //find all

                array('id' => 'DESC') //order by

            );


        return $this->render('VWAbonnementBundle:Admin:abonnements.html.twig',

            array('abonnements' => $abonnements));

    }


    public function passesAction(Request $request) {

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();

        }
        $em = $this->getDoctrine()->getManager();
        
        $RAW_QUERY = '
            SELECT a.id as ab_id, a.client_id, p.prenom, p.nom
            FROM 
                abonnement a
                INNER JOIN client c ON c.id = a.client_id
                INNER JOIN passe p ON p.abonnement_id = a.id
                
            ORDER BY ab_id DESC
            ;
            ';
        
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        $passes = $statement->fetchAll();
        $results = [];
        if($passes) {
            foreach($passes as $passe) {
                
                $passe['date'] = '';
                
                
                $RAW_QUERY3 = "
                    SELECT pa.details FROM payment pa
                    WHERE client_id = '".$passe['client_id']."'
                    ORDER BY pa.id DESC
                    LIMIT 0,100
                    ;" ;
                
                $statement3 = $em->getConnection()->prepare($RAW_QUERY3);
                $statement3->execute();
        
                $paiements = $statement3->fetchAll();
                
                if($paiements) {
                    $bool = 0;
                    foreach($paiements as $pai) {
                        $dets = json_decode($pai['details']);
                        if($dets && @$dets->TIMESTAMP && @$dets->ABONNEMENT && @$dets->CHECKOUTSTATUS) {
                            $abo = $dets->ABONNEMENT;
                            $date = $dets->TIMESTAMP;
                            $statut = $dets->CHECKOUTSTATUS;
                            if($abo == $passe['ab_id'] && $statut == 'PaymentActionCompleted') {
                                $passe['date'] = $date;
                                $bool = 1;
                                
                            }
                        }    
                    }
                    if($bool) {
                        $results[] = $passe;
                    }    
                }  
                
                
                
            }
        }

        return $this->render('VWAbonnementBundle:Admin:passes.html.twig',            array('passes' => $results));
        
    }


    public function afficherAction($abonnement_id)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }


        $em = $this->getDoctrine()->getManager();

        $abonnement = $em->getRepository('VWAbonnementBundle:Abonnement')
            ->findOneBy(array('id' => $abonnement_id));


        return $this->render('VWAbonnementBundle:Admin:abonnement.html.twig',

            array('abonnement' => $abonnement));

    }


    public function supprimerAction($abonnement_id)

    {

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }


        $em = $this->getDoctrine()->getManager();


        $abonnement = $em->getRepository('VWAbonnementBundle:Abonnement')
            ->findOneBy(array('id' => $abonnement_id));


        foreach ($abonnement->getTransactions() as $transaction) {

            $em->remove($transaction);

        }


        //Supprime les images de chaque passe

        foreach ($abonnement->getPasse() as $passe) {

            if ($passe->getImage() != null) {

                @unlink($this->get('kernel')->getRootDir() . "/../web/uploads/img/{$passe->getImage()->getId()}.png");

            }

            if ($passe->getImageConjoint() != null) {

                @unlink($this->get('kernel')->getRootDir() . "/../web/uploads/img/{$passe->getImageConjoint()->getId()}.png");

            }

            $em->remove($passe);

        }


        //Celui-là va peut-être planté, si un client possède plusieurs passes

        //$em->remove($abonnement->getClient());


        $em->remove($abonnement);


        $em->flush();


        return $this->redirectToRoute('vw_abonnement_liste');

    }


    public function voirAction($token)

    {

        $token = $this->get('payum')->getTokenStorage()->findBy(array('hash' => $token), null, 1, null);


        $gateway = $this->get('payum')->getGateway($token[0]->getGatewayName());

        $gateway->execute($status = new GetHumanStatus($token[0]));

        $payment = $status->getFirstModel();

        $abonnement = $payment->getAbonnement();


        return $this->render('VWAbonnementBundle:Abonnement:merci.html.twig', array(

            'abonnement' => $abonnement,

            'payment' => $payment

        ));

    }



    public function printAction(Request $request, $page="0")

    {

        $limit      = 16;
        $offset     = $page * $limit;
        $maxlimit   = $offset + $limit - 1 ;
        $prec       = "";
        $suiv       = "";
        $current    = "";
        

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }


        $em = $this->getDoctrine()->getManager();

        $abonnements = $em->getRepository('VWAbonnementBundle:Abonnement')
            ->findBy(
                array(),
                array('id' => 'DESC')
            );

        $arr_pass = [];
        $bool     = 0;
        if(sizeof($abonnements)>0) {
            foreach($abonnements as $ab) {
                $passes = $ab->getPasse();
                if(sizeof($passes)>0) {
                    foreach($passes as $pass) {
                        $bool = 0;
                        if(sizeof($arr_pass)>0) {
                            foreach($arr_pass as $ap) {
                                if($ap->getNom() == $pass->getNom() && $ap->getPrenom() == $pass->getPrenom()) {
                                    $bool     = 1;
                                }
                            }
                        }                     
                        if(empty($bool)) {
                            $arr_pass[] = $pass;
                        }   
                    }
                }
            }
        }

        if(sizeof($arr_pass) > $maxlimit) {
            $suiv       = '<a href="https://skigailuron.ca/fr/admin/abonnement/print/'. ($page + 1) .'">Suivant</a>';
        }
        $current       = '<a href="https://skigailuron.ca/fr/admin/abonnement/print/'.$page.'" style="margin: 0 15px;">'. ($page + 1) .'</a>';
        if($page>0) {
            $prec       = '<a href="https://skigailuron.ca/fr/admin/abonnement/print/'. ($page - 1) .'">Précedent</a>';
        }

        $print = '<a target="_blank" href="https://skigailuron.ca/fr/admin/abonnement/printpage/'.$page.'" class="btn btn-success">Imprimer</a>';

        $res = [];
        for($i=$offset; $i<= min(sizeof($arr_pass), $maxlimit); $i++ ) {
            $res[] = $arr_pass[$i];
        }


        return $this->render('VWAbonnementBundle:Admin:print.html.twig',

            array(
                'passes'    => $res,
                'current'   => $current,
                'prec'      => $prec,
                'suiv'      => $suiv,
                'print'      => $print
            ));

    }

    public function printpageAction(Request $request, $page="0")

    {

        $limit      = 16;
        $offset     = $page * $limit;
        $maxlimit   = $offset + $limit - 1 ;
        $prec       = "";
        $suiv       = "";
        $current    = "";
        

        // Restreindre cette zone aux admins (ROLE_ADMIN) seulement

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

            throw $this->createAccessDeniedException();

        }


        $em = $this->getDoctrine()->getManager();

        $abonnements = $em->getRepository('VWAbonnementBundle:Abonnement')
            ->findBy(
                array(),
                array('id' => 'DESC')
            );

        $arr_pass = [];
        if(sizeof($abonnements)>0) {
            foreach($abonnements as $ab) {
                $passes = $ab->getPasse();
                if(sizeof($passes)>0) {
                    foreach($passes as $pass) {
                        $bool = 0;
                        if(sizeof($arr_pass)>0) {
                            foreach($arr_pass as $ap) {
                                if($ap->getNom() == $pass->getNom() && $ap->getPrenom() == $pass->getPrenom()) {
                                    $bool     = 1;
                                }
                            }
                        }                     
                        if(empty($bool)) {
                            $arr_pass[] = $pass;
                        }     
                    }
                }
            }
        }

        $res = [];
        for($i=$offset; $i<= min(sizeof($arr_pass), $maxlimit); $i++ ) {
            $res[] = $arr_pass[$i];
        }


        return $this->render('VWAbonnementBundle:Admin:printpage.html.twig',

            array(
                'passes'    => $res
            ));

    }


}