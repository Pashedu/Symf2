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
    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {
        return $this->render('PasheduCompanyBundle:about:about.html.twig', array(
            'user' => 'username',
        ));
    }

    /**
     * @Route("/newsroom", name="newsroom")
     */
    public function newsroomAction()
    {
        return $this->render('PasheduCompanyBundle:about:newsroom.html.twig');
    }

    /**
     * @Route("/contacts", name="contact_page")
     */
    public function contactsAction()
    {
        return $this->render('PasheduCompanyBundle:about:contacts.html.twig');
    }
}
