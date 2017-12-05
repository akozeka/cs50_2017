<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="user_activation_token",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="UNIQ_user_activation_token", columns="value"),
 *         @ORM\UniqueConstraint(name="UNIQ_user_activation_token_account", columns={"value", "user_id"})
 * })
 */
final class UserActivationToken extends UserToken
{
    public function getType(): string
    {
        return 'user activation';
    }
}
