<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Form\Type\DeleteEntityType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

trait EntityControllerTrait
{
    public function getEntityManager(): EntityManager
    {
        return $this->getDoctrine()->getManager();
    }

    public function createDeleteForm(
        string $action,
        Request $request = null,
        string $tokenId = AppBundle::DELETE_FORM_TOKEN
    ): Form {
        $form = $this->get('form.factory')->create(DeleteEntityType::class, null, [
            'action' => $action,
            'csrf_token_id' => $tokenId,
        ]);

        return $request ? $form->handleRequest($request) : $form;
    }
}
