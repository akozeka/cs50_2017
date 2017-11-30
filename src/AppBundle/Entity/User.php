<?php

namespace AppBundle\Entity;

use AppBundle\Utils\Registration;
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
 *     },
 *     indexes={
 *         @ORM\Index(name="IDX_user_full_name", columns={"last_name", "first_name"})
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
     * @ORM\JoinColumn(onDelete="SET NULL")
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

    public function getAge(): int
    {
        return $this->birthdate ? ($this->birthdate->diff(new \DateTime()))->y : 0;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getRegisteredAt(): \DateTime
    {
        return $this->registeredAt;
    }

    public function getActivatedAt(): ?\DateTime
    {
        return $this->activatedAt;
    }

    /**
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

    public function update(Registration $registration): void
    {
        $this->email = $registration->getEmail();
        $this->firstName = $registration->firstName;
        $this->lastName = $registration->lastName;
        $this->gender = $registration->gender;
        $this->birthdate = $registration->getBirthdate();

        $address = $registration->getAddress();

        if (!$this->postAddress->equals($address)) {
            $this->postAddress = PostAddressEmbeddable::createFromAddress($address);
        }
    }

    public function isEnabled(): bool
    {
        return $this->status === self::ENABLED;
    }

    public function getLastLoggedAt(): ?\DateTime
    {
        return $this->lastLoggedAt;
    }

    public function recordLastLoggedAt(string $timestamp = 'now'): void
    {
        $this->lastLoggedAt = new \DateTime($timestamp);
    }

    public function getOffice(): ?Office
    {
        return $this->office;
    }

    public function setOffice(?Office $office): void
    {
        $this->office = $office;
    }

    public function equals(self $other): bool
    {
        return $this->id === $other->getId();
    }
}
