<?php



namespace VW\ClientBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;



use VW\ClientBundle\Entity\Client;

use VW\ClientBundle\Form\ClientType;

use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;









class DefaultController extends Controller

{

    public function indexAction()

    {

         $em = $this->getDoctrine()->getManager();

            // Pour récupérer une seule annonce, on utilise la méthode find($id)

            $clients = $em->getRepository('VWClientBundle:Client')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :

            

           

            return $this->render('VWClientBundle:Client:liste.html.twig', array(

              'clients'           => $clients,

              

            ));

        

    }

    

    public function listeAction()

    {

            $em = $this->getDoctrine()->getManager();

            // Pour récupérer une seule annonce, on utilise la méthode find($id)

            $clients = $em->getRepository('VWClientBundle:Client')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :

            

           

            return $this->render('VWClientBundle:Client:liste.html.twig', array(

              'clients'           => $clients,

              

            ));

    }

    

     public function modifierAction($id, Request $request)

          {

            

            $em = $this->getDoctrine()->getManager();

            $client = $em->getRepository('VWClientBundle:Client')->find($id);

            

             if (null === $client) {

                  throw new NotFoundHttpException("Le client d'id ".$id." n'existe pas.");

                }

            

            $form = $this->get('form.factory')->create(ClientType::class, $client);

            

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

              // Inutile de persister ici, Doctrine connait déjà notre annonce

              $em->flush();

              

                $request->getSession()->getFlashBag()->add('notice', 'Le client à bien été modifiée.');

                return $this->redirectToRoute('vw_client_voir', array('id' => $client->getId()));

            }

            

         return $this->render('VWClientBundle:Client:modifier.html.twig', array(

          'client' => $client,

          'form'   => $form->createView(),

        ));

      }

    

    

    public function ajouterAction(Request $request)

    {

       $client = new Client();

        $form   = $this->get('form.factory')->create(ClientType::class, $client);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

          $em = $this->getDoctrine()->getManager();

          $em->persist($client);

          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Client bien enregistré');

          return $this->redirectToRoute('vw_client_voir', array('id' => $client->getId()));

        }

        return $this->render('VWClientBundle:Client:ajouter.html.twig', array(

          'form' => $form->createView(),

        ));

    }

    

    public function voirAction($id)

    {

            $em = $this->getDoctrine()->getManager();

            // Pour récupérer une seule annonce, on utilise la méthode find($id)

            $client = $em->getRepository('VWClientBundle:Client')->find($id);

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :

            if (null === $client) {

              throw new NotFoundHttpException("Le client d'id ".$id." n'existe pas.");

            }

           

            return $this->render('VWClientBundle:Client:client.html.twig', array(

              'client'           => $client,

              

            ));

    }

    

    public function deleteAction(Request $request, Client $client)

          {

            $em = $this->getDoctrine()->getManager();

            // On crée un formulaire vide, qui ne contiendra que le champ CSRF

            // Cela permet de protéger la suppression d'annonce contre cette faille

            $form = $this->get('form.factory')->create();

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

              $em->remove($client);

              $em->flush();

              $request->getSession()->getFlashBag()->add('info', "Le client a bien été supprimée.");

              return $this->redirectToRoute('vw_client_homepage');

            }



            return $this->render('VWClientBundle:Client:delete.html.twig', array(

              'client' => $client,

              'form'   => $form->createView(),

            ));

          }

}

