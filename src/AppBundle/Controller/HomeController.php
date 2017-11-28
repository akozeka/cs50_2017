<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Office;
use AppBundle\Entity\OfficeCategory;
use AppBundle\Utils\UnitedNationsBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function homeAction()
    {
        return $this->render('home/home.html.twig');
    }

    /**
     * @Route("/home", name="home_redirect")
     */
    public function homeRedirectAction()
    {
        if ($this->isGranted('ROLE_USER')) {
            $route = 'user_home';
        } else if ($this->isGranted('ROLE_ADMIN')) {
            $route = 'admin_home';
        } else {
            $route = 'home';
        }

        return $this->redirectToRoute($route);
    }
}
