<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Country;
use AppBundle\Entity\Office;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/office")
 */
class OfficeController extends Controller
{
    /**
     * @Route("/list", name="office_list")
     * @Method("GET")
     */
    public function officeListAction()
    {
        $offices = $this->getDoctrine()->getRepository(Office::class)->findAll();

        return $this->render('office/list.html.twig', ['offices' => $offices]);
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

        $users = $em->getRepository(User::class)->findActiveUsersByOffice($office);
        $officeCountry = $em->getRepository(Country::class)->findOneBy(['code' => $office->getCountry()]);

        return $this->render('office/info_window.html.twig', [
            'office' => $office,
            'officeCountry' => $officeCountry,
            'users' => $users
        ]);
    }
}
