<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Twig;

use AppBundle\AppBundle;
use AppBundle\Form\Type\DeleteEntityType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormRenderer;
use Twig\Environment;

class FormRuntime
{
    private $formFactory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->formFactory = $factory;
    }

    public function createDeleteForm(
        Environment $env,
        string $action,
        string $tokenId = AppBundle::DELETE_FORM_TOKEN
    ): string {
        return $env
            ->getRuntime(FormRenderer::class)
            ->renderBlock(
                $this->formFactory->create(
                    DeleteEntityType::class,
                    null,
                    [
                        'action' => $action,
                        'csrf_token_id' => $tokenId,
                    ]
                )->createView(),
                'form'
            );
    }
}
