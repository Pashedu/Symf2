<?php

namespace Pashedu\CompanyBundle\Controller;

use Pashedu\CompanyBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 *
 * @Route("category")
 */
class CategoryController extends Controller
{
    /**
     * Lists all category entities.
     *
     * @Route("/", name="category_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('PasheduCompanyBundle:Category')->findBy(array('parent'=>null));
        //$categories = $em->getRepository('PasheduCompanyBundle:Category')->findAll();
        return $this->render('PasheduCompanyBundle:category:index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Creates a new category entity.
     *
     * @Route("/new", name="category_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm('Pashedu\CompanyBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if($category->getParent()){
                $category->setTreeroot($category->getParent()->getTreeroot());
            }
            else
            {
                $category->setTreeroot($category);
            }
            $em->persist($category);
            $em->flush();
            foreach ($category->getChildren() as $child)
            {
                $query=$em->createQueryBuilder()
                    ->update('PasheduCompanyBundle:Category','c')
                    ->set('c.treeroot','?1')
                    ->where('c.treeroot = ?2')
                    ->setParameter(1,$category->getTreeroot())
                    ->setParameter(2,$child->getTreeroot())
                    ->getQuery();
                $res=$query->execute();
                $child->setParent($category);
                $em->persist($child);
                $em->flush();
            }
            return $this->redirectToRoute('category_show', array('id' => $category->getId()));
        }

        return $this->render('PasheduCompanyBundle:category:new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a category entity.
     *
     * @Route("/{id}", name="category_show")
     * @Method("GET")
     */
    public function showAction(Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);

        return $this->render('PasheduCompanyBundle:category:show.html.twig', array(
            'category' => $category,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing category entity.
     *
     * @Route("/{id}/edit", name="category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        $editForm = $this->createForm('Pashedu\CompanyBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em=$this->getDoctrine()->getManager();
            if($category->getParent())
            {
                $category->setTreeroot($category->getParent()->getTreeroot());
            }
            else
            {
                $category->setTreeroot($category);
            }
            //$catM = $em->getRepository('PasheduCompanyBundle:Category')->find($category->getId());
            //dump($catM);

            $query=$em->createQueryBuilder()
                ->update('PasheduCompanyBundle:Category','c')
                ->set('c.parent','?1')
                ->set('c.treeroot','c.id')
                ->where('c.parent = ?2')
                ->setParameter(1,null)
                ->setParameter(2,$category->getId())
                ->getQuery();
            $res=$query->execute();
            foreach ($category->getChildren() as $child)
            {
                $child->setParent($category);
                $child->setTreeroot($category->getTreeroot());
                $em->persist($child);
                $em->flush();
            }
            $em->persist($category);
            $em->flush();
            //return $this->redirectToRoute('category_edit', array('id' => $category->getId()));
            return $this->redirectToRoute('category_index');
        }

        return $this->render('PasheduCompanyBundle:category:edit.html.twig', array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a category entity.
     *
     * @Route("/{id}", name="category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('category_index');
    }

    /**
     * Creates a form to delete a category entity.
     *
     * @param Category $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
