<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\UserActivationToken;
use AppBundle\Form\RegistrationFormType;
use AppBundle\Utils\Registration;
use GuzzleHttp\Exception\ConnectException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="register")
     * @Method("GET|POST")
     */
    public function registerAction(Request $request): Response
    {
        $registration = Registration::createWithRecaptcha($request->request->get('g-recaptcha-response'));

        $form = $this->createForm(RegistrationFormType::class, $registration)
            ->add('submit', SubmitType::class, ['label' => 'Register']);

        try {
            if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
                $this->get('app.registration_handler')->handle($registration);
                $this->addFlash('info', 'User registered, please wait for activation e-mail and click activation link in it.');

                return $this->redirectToRoute('homepage');
            }
        } catch (ConnectException $e) {
            $this->addFlash('error', 'Recaptcha error!');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
            'registration' => $registration,
        ]);
    }

    /**
     * @Route(
     *     path="/registration/activate/{user_id}/{activation_token}",
     *     name="activate",
     *     requirements={
     *         "user_id": "%pattern_id%",
     *         "activation_token": "%pattern_sha1%"
     *     }
     * )
     * @Method("GET")
     * @Entity(name="user", expr="repository.find(user_id)")
     * @Entity(name="activationToken", expr="repository.findOneBy({'value': activation_token})")
     */
    public function activateAction(User $user, UserActivationToken $activationToken): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        try {
            $this->get('app.user_account_activation_handler')->handle($user, $activationToken);
            $this->addFlash('info', 'User activated successfully');
        } catch (\Exception $e) {
            $this->addFlash('info', 'Could not activate user!');
        }

        return $this->redirectToRoute('security_login');
    }
}
