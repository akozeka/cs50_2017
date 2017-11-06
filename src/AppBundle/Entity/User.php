<?php

namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
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
    use EntityCrudTrait;
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

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Office", inversedBy="users")
     */
    private $office;

    public function getRoles(): array
    {
        return ($this->role == self::ROLE_ADMIN) ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt()
    {
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    public function getAge(): ?int
    {
        return $this->birthdate ? ($this->birthdate->diff(new \DateTime()))->y : null;
    }

    public function isEnabled(): bool
    {
        return $this->status === self::ENABLED;
    }

    public function getActivatedAt(): ?\DateTime
    {
        return $this->activatedAt;
    }

    public function changePassword(string $newPassword): void
    {
        $this->password = $newPassword;
    }

    /**
     * Activates User account with the provided activation token.
     *
     * @throws \RuntimeException
     */
    public function activate(UserActivationToken $token, string $timestamp = 'now'): void
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
     */
    public function recordLastLoggedAt(string $timestamp = 'now'): void
    {
        $this->lastLoggedAt = new \DateTime($timestamp);
    }

    public function getLastLoggedAt(): ?\DateTime
    {
        return $this->lastLoggedAt;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): User
    {
        $this->status = $status;

        return $this;
    }

    public function getRegisteredAt(): \DateTime
    {
        return $this->registeredAt;
    }

    public function getOffice(): Office
    {
        return $this->office;
    }

    public function setOffice(Office $office): User
    {
        $this->office = $office;

        return $this;
    }
}
