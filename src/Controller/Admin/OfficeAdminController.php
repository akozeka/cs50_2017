<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\EntityControllerTrait;
use AppBundle\Entity\Office;
use AppBundle\Entity\OfficeCategory;
use AppBundle\Form\OfficeCategoryFormType;
use AppBundle\Form\OfficeFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/office")
 */
class OfficeAdminController extends Controller
{
    use EntityControllerTrait;

    /**
     * @Route("/", name="admin_office_list")
     * @Method("GET")
     */
    public function officeListAction(Request $request)
    {
        return $this->render('admin/office/list.html.twig', [
            'officePagination' => $this->get('knp_paginator')->paginate(
                $this->getDoctrine()->getRepository(Office::class)->createOfficesSortedQB(),
                $request->query->getInt('page', 1),
                5,
                ['defaultSortFieldName' => 'o.name', 'defaultSortDirection' => 'asc']
            )
        ]);
    }

    /**
     * @Route("/map", name="admin_office_map")
     * @Method("GET")
     */
    public function officeMapAction()
    {
        return $this->forward('AppBundle:Office:officeMap');
    }

    /**
     * @Route("/edit", name="admin_office_add")
     * @Route("/edit/{id}", name="admin_office_edit", requirements={"id": "%pattern_id%"})
     *
     * @Method("GET|POST")
     */
    public function officeEditAction(?int $id, Request $request)
    {
        $isEditForm = ($id !== null);
        $manager = $this->getEntityManager();

        $office = $isEditForm ?
            $manager->getRepository(Office::class)->find($id) :
            new Office();

        $form = $this->createForm(OfficeFormType::class, $office);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $manager->persist($office);
            $manager->flush();

            $this->addFlash('info', 'Office ' . ($isEditForm ? 'updated' : 'added'));

            return $this->redirectToRoute('admin_office_list');
        }

        return $this->render('admin/office/edit.html.twig', [
            'form' => $form->createView(),
            'isEditForm' => $isEditForm,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_office_delete", requirements={"id": "%pattern_id%"})
     * @Method("DELETE")
     */
    public function officeDeleteAction(Request $request, Office $office)
    {
        $form = $this->createDeleteForm('', $request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getEntityManager()->remove($office);
            $this->getEntityManager()->flush();

            $this->addFlash('info', 'Office deleted');

            return $this->redirectToRoute('admin_office_list');
        }

        throw $this->createNotFoundException('Invalid office!');
    }

    /**
     * @Route("/category", name="admin_office_category_list")
     * @Method("GET")
     */
    public function officeCategoryListAction()
    {
        $categories = $this->getDoctrine()->getRepository(OfficeCategory::class)->findBy([], ['id' => 'ASC']);

        return $this->render('admin/office_category/list.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("/category/edit", name="admin_office_category_add")
     * @Route("/category/edit/{id}", name="admin_office_category_edit", requirements={"id": "%pattern_id%"})
     *
     * @Method("GET|POST")
     */
    public function officeCategoryEditAction(?int $id, Request $request)
    {
        $isEditForm = ($id !== null);
        $manager = $this->getEntityManager();

        $category = $isEditForm ?
            $manager->getRepository(OfficeCategory::class)->find($id) :
            new OfficeCategory();

        $form = $this->createForm(OfficeCategoryFormType::class, $category);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            $this->addFlash('info', 'Office category ' . ($isEditForm ? 'updated' : 'added'));

            return $this->redirectToRoute('admin_office_category_list');
        }

        return $this->render('admin/office_category/edit.html.twig', [
            'form' => $form->createView(),
            'isEditForm' => $isEditForm,
        ]);
    }

    /**
     * @Route("/category/delete/{id}", name="admin_office_category_delete", requirements={"id": "%pattern_id%"})
     * @Method("DELETE")
     */
    public function officeCategoryDeleteAction(Request $request, OfficeCategory $category)
    {
        $form = $this->createDeleteForm('', $request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getEntityManager()->remove($category);
            $this->getEntityManager()->flush();

            $this->addFlash('info', 'Office category deleted');

            return $this->redirectToRoute('admin_office_category_list');
        }

        throw $this->createNotFoundException('Invalid category!');
    }
}
