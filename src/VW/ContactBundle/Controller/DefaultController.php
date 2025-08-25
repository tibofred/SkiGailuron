<?php



namespace VW\ContactBundle\Controller;



use VW\ContactBundle\Entity\Contact;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;





class DefaultController extends Controller

{

	

public function addAction(Request $request)

  {

    // On crée un objet Advert

    $contact = new Contact();



    // On crée le FormBuilder grâce au service form factory

    $form = $this->get('form.factory')->createBuilder(FormType::class, $contact)



    // On ajoute les champs de l'entité que l'on veut à notre formulaire

    

      ->add('name',         TextType::class)

      ->add('email',        EmailType::class)

      ->add('phone',        TextType::class, array(

                'required'   => false))

      ->add('subject',      TextType::class)

      ->add('message',      TextareaType::class)

      ->add('envoyer',      SubmitType::class)

      ->getForm()

    ;





    // Si la requête est en POST

    if ($request->isMethod('POST')) {

      // On fait le lien Requête <-> Formulaire

      // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur

      $form->handleRequest($request);



      // On vérifie que les valeurs entrées sont correctes

      // (Nous verrons la validation des objets en détail dans le prochain chapitre)

      if ($form->isValid()) {

        // On enregistre notre objet $advert dans la base de données, par exemple

        $em = $this->getDoctrine()->getManager();

        $em->persist($contact);

        $em->flush();

        

          $data = $request->request->get('form');

          $email = $data['email'];

          $name = $data['name'];

          $phone = $data['phone'];

          $subject = $data['subject'];

          $contenu = $data['message'];

          

        $message = \Swift_Message::newInstance()

        ->setSubject('ViWeb - Message bien reçu')

        ->setFrom('info@skigailuron.ca')

        ->setTo( $email )

        ->setBody(

            $this->renderView(



                'VWContactBundle:Default:message-client.html.twig', array(

                    'email' => $email,

                    'phone' => $phone,

                    'name' => $name,

                    'contenu' => $contenu

                    

                )

            ),

            'text/html'

        )

        /*

         * If you also want to include a plaintext version of the message

        ->addPart(

            $this->renderView(

                'Emails/registration.txt.twig',

                array('name' => $name)

            ),

            'text/plain'

        )

        */

    ;

    $this->get('mailer')->send($message);

          

          

          

    $message2 = \Swift_Message::newInstance()

        ->setSubject('ViWeb - Message bien reçu')

        ->setFrom('siteweb@skigailuron.ca')

        ->setTo( 'info@skigailuron.ca' )

        ->setBody(

            $this->renderView(

                

                'VWContactBundle:Default:message.html.twig', array(

                    'email' => $email,

                    'phone' => $phone,

                    'name' => $name,

                    'subject' => $subject,

                    'contenu' => $contenu

                    

                )

            ),

            'text/html'

        )

        /*

         * If you also want to include a plaintext version of the message

        ->addPart(

            $this->renderView(

                'Emails/registration.txt.twig',

                array('name' => $name)

            ),

            'text/plain'

        )

        */

    ;

    $this->get('mailer')->send($message2);



    return $this->redirectToRoute('vw_contact_envoye', array('id' => $contact->getId()));



      	}

    }



    // On passe la méthode createView() du formulaire à la vue

    // afin qu'elle puisse afficher le formulaire toute seule

    return $this->render('VWContactBundle:Default:index.html.twig', array(

      'form' => $form->createView(),

    ));

  }



  public function envoyeAction($id)

  {

    // On récupère le repository

    $repository = $this->getDoctrine()

      ->getManager()

      ->getRepository('VWContactBundle:Contact')

    ;



    // On récupère l'entité correspondante à l'id $id

    $contact = $repository->find($id);



    // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

    // ou null si l'id $id  n'existe pas, d'où ce if :

    if (null === $contact) {

      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");

    }



    // Le render ne change pas, on passait avant un tableau, maintenant un objet

    return $this->render('VWContactBundle:Default:envoye.html.twig', array(

      'form' => $contact

    ));

  }

    

public function modelAction()

{

    

    return $this->render('VWContactBundle:Default:model-test.html.twig');

}

    



public function journalAction()

{

    $repository = $this->getDoctrine()

      ->getManager()

      ->getRepository('VWContactBundle:Contact')

    ;

    

    $courriels = $repository->findAll();

    return $this->render('VWContactBundle:Default:journal.html.twig', array(

        'courriels' => $courriels,

    ));

}





}