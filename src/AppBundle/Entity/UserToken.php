<?php

namespace AppBundle\Entity;

use AppBundle\Util\ValueObject\SHA1;
use Doctrine\ORM\Mapping as ORM;

/**
 * An abstract temporary token for User.
 *
 * @ORM\MappedSuperclass
 */
abstract class UserToken implements UserExpirableTokenInterface
{
    use EntityIdentityTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $userId;

    /**
     * @var SHA1|string
     *
     * @ORM\Column(length=40)
     */
    private $value;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $expiredAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $usedAt;

    private function __construct(User $user, \DateTime $createdAt, \DateTime $expirationAt, SHA1 $value)
    {
        if ($expirationAt <= new \DateTime()) {
            throw new \InvalidArgumentException('Expiration date must be in the future!');
        }

        $this->userId = $user->getId();
        $this->createdAt = $createdAt;
        $this->expiredAt = $expirationAt;
        $this->value = $value;
    }

    public static function generate(User $user, string $lifetime = '+1 day'): UserExpirableTokenInterface
    {
        $now = new \DateTime();

        return new static($user, $now, new \DateTime($lifetime), SHA1::hash($user->getId().$now->format('U')));
    }

    public function getValue(): SHA1
    {
        if (!$this->value instanceof SHA1) {
            $this->value = SHA1::fromString($this->value);
        }

        return $this->value;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUsageDate(): \DateTime
    {
        if ($this->usedAt instanceof \DateTime) {
            $this->usedAt = new \DateTime($this->usedAt->format(\DateTime::RFC2822), $this->usedAt->getTimezone());
        }

        return $this->usedAt;
    }

    public function consume(User $user): void
    {
        if ($this->usedAt !== null) {
            throw new \RuntimeException('User token already used!');
        }

        if ($this->userId !== $user->getId()) {
            throw new \RuntimeException('User token mismatch!');
        }

        if ($this->isExpired()) {
            throw new \RuntimeException('User token already expired!');
        }

        $this->usedAt = new \DateTime();
    }

    private function isExpired(): bool
    {
        return new \DateTime() > $this->expiredAt;
    }
}
