<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\EntityControllerTrait;
use AppBundle\Entity\OfficeCategory;
use AppBundle\Form\OfficeCategoryFormType;
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
     * @Route("/category/list", name="admin_office_category_list")
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
            new OfficeCategory()
        ;

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
