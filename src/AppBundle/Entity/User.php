<?php

namespace AppBundle\Entity;

use AppBundle\Utils\Geo\AddressInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(
 *     name="user",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="UNIQ_user_email", columns="email")
 *     }
 * )
 */
class User implements UserInterface, AddressInterface
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

    public function __construct(
        string $email,
        string $firstName,
        string $lastName,
        string $gender,
        \DateTime $birthdate,
        string $password,
        string $role,
        string $status,
        PostAddressEmbeddable $postAddress,
        ?Office $office = null
    ) {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->birthdate = $birthdate;
        $this->password = $password;
        $this->role = $role;
        $this->status = $status;
        $this->registeredAt = new \DateTime();
        $this->postAddress = $postAddress;
        $this->office = $office;
    }

    public function getRoles(): array
    {
        return ($this->role == self::ROLE_ADMIN) ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    public function getPassword(): string
    {
        return $this->password;
    }

//    public function setPassword($password): self
//    {
//        $this->password = $password;
//
//        return $this;
//    }

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

//    public function setEmail(string $email): self
//    {
//        $this->email = $email;
//
//        return $this;
//    }

    public function getGender(): string
    {
        return $this->gender;
    }

//    public function setGender(string $gender): self
//    {
//        $this->gender = $gender;
//
//        return $this;
//    }

    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

//    public function setBirthdate(?\DateTime $birthdate): self
//    {
//        $this->birthdate = $birthdate;
//
//        return $this;
//    }

    public function getAge(): int
    {
        return $this->birthdate ? ($this->birthdate->diff(new \DateTime()))->y : 0;
    }

    public function getRole(): string
    {
        return $this->role;
    }

//    public function setRole(string $role): self
//    {
//        $this->role = $role;
//
//        return $this;
//    }

    public function getStatus(): string
    {
        return $this->status;
    }

//    public function setStatus(string $status): self
//    {
//        $this->status = $status;
//
//        return $this;
//    }

    public function getRegisteredAt(): \DateTime
    {
        return $this->registeredAt;
    }

//    public function setRegisteredAt(\DateTime $registeredAt): self
//    {
//        $this->registeredAt = $registeredAt;
//
//        return $this;
//    }

    public function getActivatedAt(): ?\DateTime
    {
        return $this->activatedAt;
    }

    /**
     * Activates User account with the provided activation token.
     *
     * @throws \RuntimeException
     */
    public function activate(UserActivationToken $token, string $timestamp = 'now'): void
    {
        if ($this->activatedAt) {
            throw new \RuntimeException('User already activated!');
        }

        $token->consume($this);

        $this->status = self::ENABLED;
        $this->activatedAt = new \DateTime($timestamp);
    }

    public function isEnabled(): bool
    {
        return $this->status === self::ENABLED;
    }

    public function getLastLoggedAt(): ?\DateTime
    {
        return $this->lastLoggedAt;
    }

    /**
     * Records User's last login datetime.
     */
    public function recordLastLoggedAt(string $timestamp = 'now'): void
    {
        $this->lastLoggedAt = new \DateTime($timestamp);
    }

    public function getOffice(): Office
    {
        return $this->office;
    }

//    public function setOffice(Office $office): self
//    {
//        $this->office = $office;
//
//        return $this;
//    }

    public function equals(self $other): bool
    {
        return $this->id === $other->getId();
    }
}
