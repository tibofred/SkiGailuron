<?php



namespace VW\BaseBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use VW\SeoBundle\Form\SeoType;

use VW\BaseBundle\Entity\Mailchimp;

use VW\BaseBundle\Form\MailchimpType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Welp\MailchimpBundle\Event\SubscriberEvent;

use Welp\MailchimpBundle\Subscriber\Subscriber;



class DefaultController extends Controller

{

    public function indexAction()

    {

        return $this->render('VWBaseBundle:Default:index.html.twig');

    }





    public function aboutAction()

    {

        return $this->render('VWBaseBundle:Pages:about.html.twig');

    }

    

    public function conceptionAction()

    {

        return $this->render('VWBaseBundle:Pages:conception.html.twig');

    }

    

    public function referencementAction()

    {

        return $this->render('VWBaseBundle:Pages:referencement.html.twig');

    }

    

    

    public function hebergementAction()

    {

        return $this->render('VWBaseBundle:Pages:hebergement.html.twig');

    }



    public function reserveAction()

    {



    	// On vérifie que l'utilisateur dispose bien du rôle ROLE_AUTEUR



	    if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {



	      // Sinon on déclenche une exception « Accès interdit »



	      throw new AccessDeniedException('Accès limité aux auteurs.');



	    }



	        return $this->render('VWBaseBundle:Default:reserve.html.twig');

	    }

    

    

    public function addAction(Request $request)



          {



            $seo = new Seo();



            $form   = $this->get('form.factory')->create(SeoType::class, $seo);





            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {



              $em = $this->getDoctrine()->getManager();



              $em->persist($seo);



              $em->flush();





              $request->getSession()->getFlashBag()->add('notice', 'Seo bien enregistrée.');





              return $this->redirectToRoute('vw_seo_view', array('id' => $advert->getId()));



            }





            return $this->render('VWSeoBundle:Seo:add.html.twig', array(



              'form' => $form->createView(),



            ));



          }

    

    public function infolettreAction(Request $request)

    {

        

        

        

        

    $inscription = new Mailchimp();

        

        $form = $this->get('form.factory')->create(MailchimpType::class, $inscription);



       

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

        

               $data = $request->request->get('form');

               $email = $data['email'];

            

              $subscriber = new Subscriber('admin@viweb.ca', [

                    'FIRSTNAME' => $data['email'] ,

                ], [

                    'language' => 'fr'

                ]);



                $this->container->get('event_dispatcher')->dispatch(

                    SubscriberEvent::EVENT_SUBSCRIBE,

                    new SubscriberEvent('cbb5fcbef0', $subscriber)

                );

            

            

            $subscriber = new Subscriber('admin@viweb.ca', [

                    'FIRSTNAME' => 'frederic',

                ], [

                    'language' => 'fr'

                ]);



                $this->container->get('event_dispatcher')->dispatch(

                    SubscriberEvent::EVENT_SUBSCRIBE,

                    new SubscriberEvent('cbb5fcbef0', $subscriber)

                );



          $em = $this->getDoctrine()->getManager();

          // On persiste car Doctrine ne connait pas encore cette objet, on  lui donne en charge

          $em->persist($inscription);

          // On crée l'objet (on met en base de donnée)

          $em->flush();

          

          // Si tout c'est bien passé on crée le message 

          $request->getSession()->getFlashBag()->add('notice', 'Courriel bien enregistré');

          

          // On renvoi vers la page qui a été créé

          return $this->redirectToRoute('vw_base_homepage');

        }

        

        

        

        return $this->render('VWBaseBundle:Default:infolettre.html.twig', array(

          'form' => $form->createView(),

        ));

    }



    public function cookAction() {
        @session_start();
        if(!empty($_COOKIE["cookaccept"])) {
            return $this->render('VWBaseBundle:Default:cookempty.html.twig', array());
        } else {
            if(empty($_SESSION['sess_cook'])) {
                return $this->render('VWBaseBundle:Default:cook.html.twig', array());
            } else {
                return $this->render('VWBaseBundle:Default:cookempty.html.twig', array());
            }
        }    
    }
    
    public function politiqueAction() {
        return $this->render('VWBaseBundle:Default:politique.html.twig', array());
    }
    
    public function declarationAction() {
        return $this->render('VWBaseBundle:Default:declaration.html.twig', array());
    }
    
    public function acceptcoockiAction() {
        @session_start();
        $_SESSION['sess_cook'] = 'accept';
        setcookie( "cookaccept", 'accept', strtotime( '+7 days' ) , "/~acceptdb/", "skigailuron.ca", 1);
        return $this->render('VWBaseBundle:Default:cookempty.html.twig', array());
    }
    
    public function refusecoockiAction() {
        @session_start();
        $_SESSION['sess_cook'] = 'refuse';
        return $this->render('VWBaseBundle:Default:cookempty.html.twig', array());
    }
    
    public function pixelsAction() {
        @session_start();
        
        if(!empty($_COOKIE["cookaccept"])) {
            return $this->render('VWBaseBundle:Default:pixels.html.twig', array()); 
        } else {
            if(!empty($_SESSION['sess_cook'])) {
                if($_SESSION['sess_cook'] == 'accept') {
                    return $this->render('VWBaseBundle:Default:pixels.html.twig', array());   
                } else {
                    return $this->render('VWBaseBundle:Default:cookempty.html.twig', array());    
                }
            } else {
                return $this->render('VWBaseBundle:Default:pixels.html.twig', array());   
            }
        }    
    }

}

