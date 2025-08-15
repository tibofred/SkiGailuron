<?php



namespace VW\SeoBundle\Controller;



use VW\SeoBundle\Entity\Seo;

use VW\SeoBundle\Form\SeoType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class SeoController extends Controller

{

    public function indexAction()

    {

        return $this->render('VWSeoBundle:Seo:index.html.twig');

    }

    

    public function addAction(Request $request)

      {

        $seo = new Seo();

        $form   = $this->get('form.factory')->create(SeoType::class, $seo);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

          $em = $this->getDoctrine()->getManager();

          $em->persist($seo);

          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Seo bien enregistre.');

          return $this->redirectToRoute('vw_seo_view', array('id' => $seo->getId()));

        }

        return $this->render('VWSeoBundle:Seo:add.html.twig', array(

          'form' => $form->createView(),

        ));

      }

    

    

      public function viewAction($metaUrl)

          {

            

          $repository = $this->getDoctrine()

            ->getManager()

            ->getRepository('VWSeoBundle:Seo')

            ;

          

          

          // On récupère l'entité correspondante à l'id $id

            $seo = $repository->findByMetaUrl($metaUrl);



            // $advert est donc une instance de OC\PlatformBundle\Entity\Advert

            // ou null si l'id $id  n'existe pas, d'où ce if :

            if (null === $seo) {

              throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");

            }



            // Le render ne change pas, on passait avant un tableau, maintenant un objet

            return $this->render('VWSeoBundle:Seo:view.html.twig', array(

              'seo' => $seo

            ));

          }

}

