<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="user",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="UNIQ_user_email", columns="email")
 *     }
 * )
 */
class User implements UserInterface
{
    const ENABLED = 'enabled';
    const DISABLED = 'disabled';

    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    use EntityIdentityTrait;
    use EntityPersonNameTrait;
    use EntityPostAddressTrait;
    use TimestampableEntity;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $gender;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=5, options={"default"=User::ROLE_USER})
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=10, options={"default"=User::DISABLED})
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registeredAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $activatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLoggedAt;

    public function getRoles()
    {
        return ($this->role == self::ROLE_ADMIN) ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function isEnabled()
    {
        return $this->status === self::ENABLED;
    }

    public function getActivatedAt()
    {
        return $this->activatedAt;
    }

    public function changePassword($newPassword)
    {
        $this->password = $newPassword;
    }

    /**
     * Activates User account with the provided activation token.
     *
     * @param UserActivationToken $token
     * @param string|int $timestamp
     *
     * @throws \RuntimeException
     */
    public function activate(UserActivationToken $token, $timestamp = 'now')
    {
        if ($this->activatedAt) {
            throw new \RuntimeException('User already enabled!');
        }

        $token->consume($this);

        $this->status = self::ENABLED;
        $this->activatedAt = new \DateTime($timestamp);
    }

    /**
     * Records User's last login datetime.
     *
     * @param string|int $timestamp
     */
    public function recordLastLoggedAt($timestamp = 'now')
    {
        $this->lastLoggedAt = new \DateTime($timestamp);
    }

    public function getLastLoggedAt()
    {
        return $this->lastLoggedAt;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }
}