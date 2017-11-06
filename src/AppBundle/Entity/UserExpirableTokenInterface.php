<?php

namespace AppBundle\Entity;

use AppBundle\Util\ValueObject\SHA1;

interface UserExpirableTokenInterface
{
    public static function generate(User $user, string $lifetime = '+1 day'): self;

    public function getValue(): SHA1;

    public function getUserId(): int;

    public function getUsageDate(): \DateTime;

    public function consume(User $user): void;

    public function getType(): string;
}
