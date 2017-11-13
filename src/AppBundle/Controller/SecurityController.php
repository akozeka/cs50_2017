<?php

namespace AppBundle\Controller;

use AppBundle\Form\LoginFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     * @Method("GET")
     */
    public function loginAction(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        $securityUtils = $this->get('security.authentication_utils');

        $form = $this->get('form.factory')->createNamed('', LoginFormType::class, [
            '_email' => $securityUtils->getLastUsername(),
        ]);

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'error' => $securityUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/login_check", name="security_login_check")
     * @Method("POST")
     */
    public function loginCheckAction()
    {
    }

    /**
     * @Route("/logout", name="security_logout")
     * @Method("GET")
     */
    public function logoutAction()
    {
    }
}
