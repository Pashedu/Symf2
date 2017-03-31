<?php

namespace Pashedu\CompanyBundle\Controller;

use Pashedu\CompanyBundle\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('PasheduCompanyBundle:Default:index.html.twig');
    }
    /**
     * @Route("/addcompany")
     */
    public  function addCompanyAction()
    {

        $company = new Company();
        $form = $this->createForm('Pashedu\CompanyBundle\Form\CompanyType', $company);
        $em = $this->getDoctrine()->getManager();
        $companies = $em->getRepository('PasheduCompanyBundle:Company')->findAll();

        return $this->render('PasheduCompanyBundle:Default:addcompany.html.twig', array(
            'companies'=>$form->createView()));
    }
}
