<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProfileFormType;
use AppBundle\Utils\Registration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/profile")
 */
class ProfileController extends Controller
{
    /**
     * @Route("/", name="user_home")
     * @Method("GET")
     */
    public function userHomeAction()
    {
        return $this->render('user/home.html.twig', ['user' => $this->getUser()]);
    }

    /**
     * @Route("/edit", name="user_edit")
     * @Method("GET|POST")
     */
    public function userEditAction(Request $request): Response
    {
        $user = $this->getUser();
        $registration = Registration::createFromUser($user);

        $form = $this->createForm(ProfileFormType::class, $registration)
            ->add('submit', SubmitType::class, ['label' => 'Save']);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->get('app.registration_handler')->update($user, $registration);
            $this->addFlash('info', 'Profile updated');

            return $this->redirectToRoute('user_home');
        }

        return $this->render('user/profile.html.twig', ['form' => $form->createView()]);
    }
}
