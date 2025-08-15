<?php



namespace VW\ClientBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;



use VW\ClientBundle\Entity\Ville;

use VW\ClientBundle\Form\VilleType;

use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;









class VilleController extends Controller

{

    public function indexAction()

    {

         

        $em = $this->getDoctrine()->getManager();

            // Pour récupérer une seule annonce, on utilise la méthode find($id)

            $villes = $em->getRepository('VWClientBundle:Ville')->findAll();

            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id n'existe pas, d'où ce if :

            

           

            return $this->render('VWClientBundle:Ville:liste.html.twig', array(

              'villes'           => $villes,

              

            ));

        

    }

    



    

     public function modifierAction($id, Request $request)

          {

            

            $em = $this->getDoctrine()->getManager();

            $ville = $em->getRepository('VWClientBundle:Ville')->find($id);

            

             if (null === $ville) {

                  throw new NotFoundHttpException("La ville d'id ".$id." n'existe pas.");

                }

            

            $form = $this->get('form.factory')->create(VilleType::class, $ville);

            

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

              // Inutile de persister ici, Doctrine connait déjà notre annonce

              $em->flush();

              

                $request->getSession()->getFlashBag()->add('notice', 'La ville à bien été modifiée.');

                return $this->redirectToRoute('vw_ville_homepage', array('id' => $ville->getId()));

            }

            

         return $this->render('VWClientBundle:Ville:modifier.html.twig', array(

          'city' => $ville,

          'form'   => $form->createView(),

        ));

      }

    

    

    public function ajouterAction(Request $request)

    {

       $ville = new Ville();

        $form   = $this->get('form.factory')->create(VilleType::class, $ville);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

          $em = $this->getDoctrine()->getManager();

          $em->persist($ville);

          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Ville bien enregistré');

          return $this->redirectToRoute('vw_ville_homepage', array('id' => $ville->getId()));

        }

        return $this->render('VWClientBundle:Ville:ajouter.html.twig', array(

          'form' => $form->createView(),

        ));

    }

    

   

}

