<?php



namespace VW\BaseBundle\Controller;



use VW\BaseBundle\Entity\Pages;

use VW\BaseBundle\Form\PagesType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class PagesController extends Controller

{

    

    public function boutiqueAction()

        {

            return $this->render('VWBaseBundle:Pages:atelier-location.html.twig');

        } 

    

    public function ecoleAction()

        {

            return $this->render('VWBaseBundle:Pages:ecole.html.twig');

        } 
    
    public function covidAction()

        {

            return $this->render('VWBaseBundle:Pages:covid.html.twig');

        } 
    
    
    public function venteAction()

        {

            return $this->render('VWBaseBundle:Pages:vente-annuelle.html.twig');

        } 
    
    
     public function gallerieAction()

        {

            return $this->render('VWBaseBundle:Pages:gallerie.html.twig');

        } 
    
    
     public function receptionAction()

        {

            return $this->render('VWBaseBundle:Pages:reception.html.twig');

        } 
    
    
     public function eventsAction()

        {

            return $this->render('VWBaseBundle:Pages:events.html.twig');

        } 
    
    
     public function testAction()

        {

            return $this->render('VWBaseBundle:Pages:test.html.twig');

        } 



}