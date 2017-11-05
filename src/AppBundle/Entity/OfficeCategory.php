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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Office", inversedBy="categories")
     */
    private $offices;

    /**
     * OfficeCategory constructor.
     */
    public function __construct()
    {
        $this->offices = new ArrayCollection();
    }
}
