<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MouseController extends Controller
{
    /**
     * @Route("/mouse")
     */
    public function mouseAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/mouse.html.twig', array('mouse'=>'Proba'));
    }
}
