<?php

namespace Test\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TestClientBundle:Default:index.html.twig');
    }
}
