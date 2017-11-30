<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Office;
use AppBundle\Entity\OfficeCategory;
use AppBundle\Utils\UnitedNationsBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class HomeAdminController extends Controller
{
    /**
     * @Route("/home", name="admin_home")
     */
    public function homeAction()
    {
        return $this->render('admin/home/home.html.twig');
    }
}
