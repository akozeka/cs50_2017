<?php

namespace AppBundle\Utils;

use AppBundle\Entity\EntityPostAddressTrait;
use AppBundle\Entity\PostAddressEmbeddable;
use AppBundle\Entity\User;
use AppBundle\Utils\ValueObject\Genders;
use AppBundle\Validator\UniqueRegistration as AssertUniqueRegistration;
use AppBundle\Validator\Recaptcha as AssertRecaptcha;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @AssertUniqueRegistration
 */
class Registration implements RegistrationInterface
{
    use EntityPostAddressTrait;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @Assert\Length(max=255)
     */
    public $email = '';

    /**
     * @Assert\Choice(
     *     callback={"AppBundle\Utils\ValueObject\Genders", "all"},
     *     strict=true
     * )
     */
    public $gender = Genders::MALE;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *   min=2,
     *   max=50
     * )
     */
    public $firstName = '';

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *   min=2,
     *   max=50
     * )
     */
    public $lastName = '';

    /**
     * @Assert\NotBlank(groups="Registration")
     * @Assert\Length(min=6, groups={"Registration"})
     */
    public $password = '';

    /**
     * @Assert\IsTrue(groups={"Registration"})
     */
    public $conditions = false;

    /**
     * @Assert\NotBlank
     * @Assert\Range(max="-15 years")
     */
    public $birthdate = null;

    public $office = null;

    /**
     * @Assert\NotBlank(groups="Registration")
     * @AssertRecaptcha(groups={"Registration"})
     */
    public $recaptcha = null;

    public function __construct()
    {
        $this->postAddress = new PostAddressEmbeddable('UA', 'Mariupol');
    }

    public static function createWithRecaptcha(string $recaptchaAnswer = null): self
    {
        $dto = new self();
        $dto->recaptcha = $recaptchaAnswer;

        return $dto;
    }

    public static function createFromUser(User $user): self
    {
        $dto = new self();
        $dto->email = $user->getEmail();
        $dto->gender = $user->getGender();
        $dto->firstName = $user->getFirstName();
        $dto->lastName = $user->getLastName();
        $dto->birthdate = $user->getBirthdate();
        $dto->postAddress = $user->getPostAddress();
        $dto->office = $user->getOffice();

        return $dto;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = mb_strtolower($email);
    }

    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTime $birthdate = null): void
    {
        $this->birthdate = $birthdate;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getOffice()
    {
        return $this->office;
    }

    public function getConditions()
    {
        return $this->conditions;
    }
}
