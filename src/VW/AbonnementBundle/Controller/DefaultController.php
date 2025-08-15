<?php



namespace VW\AbonnementBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class DefaultController extends Controller

{

    public function indexAction()

    {

        return $this->render('VWAbonnementBundle:Default:index.html.twig');

    }

}

