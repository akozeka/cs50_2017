<?php

namespace AppBundle\Utils\ValueObject;

final class SHA1
{
    private $hash;

    private function __construct($hash)
    {
        if (!preg_match('/^[a-f0-9]{40}/i', $hash)) {
            throw new \InvalidArgumentException("The given hash \"{$hash}\" does not have a valid SHA-1 format!");
        }

        $this->hash = $hash;
    }

    public static function hash($string)
    {
        return new self(sha1($string));
    }

    public static function fromString(string $hash, $preserveCase = false)
    {
        if (!$preserveCase) {
            $hash = mb_strtolower($hash);
        }

        return new self($hash);
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function equals(SHA1 $other, $strict = false)
    {
        if (!$strict) {
            return hash_equals(mb_strtolower($this->hash), mb_strtolower($other->getHash()));
        }

        return hash_equals($this->hash, $other->getHash());
    }

    public function __toString()
    {
        return $this->hash;
    }
}