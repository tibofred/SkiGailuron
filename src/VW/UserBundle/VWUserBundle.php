<?php

// src/VW/UserBundle/OCUserBundle.php



namespace VW\UserBundle;



use Symfony\Component\HttpKernel\Bundle\Bundle;



class VWUserBundle extends Bundle

{

  public function getParent()

  {

    return 'FOSUserBundle';

  }

}