<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="office_category",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="UNIQ_office_category_code", columns="code")
 *     },
 *     indexes={
 *         @ORM\Index(name="IDX_office_category_name", columns="name")
 *     }
 * )
 * @UniqueEntity("code")
 */
class OfficeCategory
{
    use EntityIdentityTrait;
    use EntityCrudTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2, unique=true, options={"fixed": true})
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var Office[]|Collection|iterable
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Office", mappedBy="categories")
     */
    private $offices;

    public function __construct()
    {
        $this->offices = new ArrayCollection();
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code)
    {
        $this->code = $code;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getOffices()
    {
        return $this->offices;
    }
}
