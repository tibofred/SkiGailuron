<?php



namespace VW\SoumissionBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use VW\SoumissionBundle\Entity\Soumission;

use VW\SoumissionBundle\Form\SoumissionType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;











class DefaultController extends Controller

{

    public function soumissionAction(Request $request)

    {

        

        $soumission = new Soumission();



            $form   = $this->get('form.factory')->create(SoumissionType::class, $soumission);





            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {



              $em = $this->getDoctrine()->getManager();



              $em->persist($soumission);



              $em->flush();

              $request->getSession()->getFlashBag()->add('notice', 'Soumission réussi.');

    

        $data = $request->request->get('form');

          $email = $data['client.courriel'];

          $name = $data['client.nom'];

          $phone = $data['client.telPerso'];

                

                

    // Message envoyé au client

                

    $message = \Swift_Message::newInstance()

        ->setSubject('Soumission ViWeb')

        ->setFrom('info@viweb.ca')

        ->setTo( 'frederic@viweb.ca' )

        ->setBody(

            $this->renderView(

                // app/Resources/views/Emails/registration.html.twig

                'VWSoumissionBundle:Soumission:client.html.twig', array(

                    'courriel' => $email,

                    'nom' => $name,

                )

            ),

            'text/html'

        );           

    $this->get('mailer')->send($message);

                

    

     // Message envoyé à nous

    $message2 = \Swift_Message::newInstance()

        ->setSubject('Nouvelle soumission')

        ->setFrom('info@viweb.ca')

        ->setTo( 'info@viweb.ca' )

        ->setBody(

            $this->renderView(

                

                'VWSoumissionBundle:Soumission:message.html.twig', array(

                    'courriel' => $email,

                    'nom' => $name,



                    

                )

            ),

            'text/html'

        ) ;

                

        // On renvoi le client sur une page

                

       $this->get('mailer')->send($message2);

         return $this->redirectToRoute('vw_soumission_envoye', array('id' => $soumission->getId()));



       }



    

        // Si le client n'a pas rempli le formulaire on l'envoi sur le formulaire.

       return $this->render('VWSoumissionBundle:Soumission:soumission.html.twig', array(



         'form' => $form->createView(),



       ));

      

    }

    

    

    public function envoyeAction($id)

      {

        // On récupère le repository

        $repository = $this->getDoctrine()

          ->getManager()

          ->getRepository('VWSoumissionBundle:Soumission')

        ;



        // On récupère l'entité correspondante à l'id $id

        $soumission = $repository->find($id);



        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

        // ou null si l'id $id  n'existe pas, d'où ce if :

        if (null === $soumission) {

          throw new NotFoundHttpException("La soumission d'id ".$id." n'existe pas.");

        }



        // Le render ne change pas, on passait avant un tableau, maintenant un objet

        return $this->render('VWSoumissionBundle:Soumission:envoye.html.twig', array(

          'soumission' => $soumission

        ));

      }

    

    public function allAction()

      {

                $repository = $this

                ->getDoctrine()

                ->getManager()

                ->getRepository('VWSoumissionBundle:Soumission')

              ;



              $listSoumission = $repository->findAll();

        

            return $this->render('VWSoumissionBundle:Soumission:index.html.twig', array(

              'listSoumission' => $listSoumission,

            ));



      }

    

     public function viewAction($id)

      {

                $repository = $this

                ->getDoctrine()

                ->getManager()

                ->getRepository('VWSoumissionBundle:Soumission')

              ;



              $soumission = $repository->findOneById($id);

        

            return $this->render('VWSoumissionBundle:Soumission:single.html.twig', array(

              'soumission' => $soumission,

            ));



      }

    

    public function deleteAction(Request $request, Soumission $soumission)

          {

            $em = $this->getDoctrine()->getManager();

            // On crée un formulaire vide, qui ne contiendra que le champ CSRF

            // Cela permet de protéger la suppression d'annonce contre cette faille

            $form = $this->get('form.factory')->create();

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

              $em->remove($soumission);

              $em->flush();

              $request->getSession()->getFlashBag()->add('info', "La soumission a bien été supprimée.");

              return $this->redirectToRoute('vw_soumission_all');

            }



            return $this->render('VWSoumissionBundle:Soumission:delete.html.twig', array(

              'soumission' => $soumission,

              'form'   => $form->createView(),

            ));

          }



}

