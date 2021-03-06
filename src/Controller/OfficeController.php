<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Country;
use AppBundle\Entity\Office;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/office")
 */
class OfficeController extends Controller
{
    /**
     * @Route("/", name="office_list")
     * @Method("GET")
     */
    public function officeListAction(Request $request)
    {
        return $this->render('office/list.html.twig', [
            'officePagination' => $this->get('knp_paginator')->paginate(
                $this->getDoctrine()->getRepository(Office::class)->createOfficesSortedQB(),
                $request->query->getInt('page', 1),
                5,
                ['defaultSortFieldName' => 'o.name', 'defaultSortDirection' => 'asc']
            )
        ]);
    }

    /**
     * @Route("/map", name="office_map")
     * @Method("GET")
     */
    public function officeMapAction()
    {
        $offices = $this->getDoctrine()->getRepository(Office::class)->findAll();

        return $this->render('office/map.html.twig', ['offices' => $offices]);
    }

    /**
     * @Route("/{slug}", name="office_view")
     *
     * @Method("GET")
     * @Entity("office", expr="repository.findOneBy({slug: slug})")
     */
    public function officeViewAction(Office $office)
    {
        $em = $this->getDoctrine();

        $officeCountry = $em->getRepository(Country::class)->findOneBy(['code' => $office->getCountry()]);
        $users = $em->getRepository(User::class)->findActiveUsersByOffice($office);

        return $this->render('office/view.html.twig', [
            'office' => $office,
            'officeCountry' => $officeCountry,
            'users' => $users,
        ]);
    }

    /**
     * @Route("/info_window/{id}", requirements={"id": "\d*"}, name="office_info_window")
     *
     * @Method("GET")
     * @Entity("office", expr="repository.find(id)")
     */
    public function officeInfoWindowAction(Office $office)
    {
        $em = $this->getDoctrine();

        $officeCountry = $em->getRepository(Country::class)->findOneBy(['code' => $office->getCountry()]);
        $users_count = $em->getRepository(User::class)->countActiveUsersByOffice($office);

        return $this->render('office/info_window.html.twig', [
            'office' => $office,
            'officeCountry' => $officeCountry,
            'users_count' => $users_count
        ]);
    }
}
