<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="country",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="UNIQ_country_code", columns="code")
 *     },
 *     indexes={
 *         @ORM\Index(name="IDX_country_name", columns="name")
 *     }
 * )
 * @UniqueEntity("code")
 */
class Country
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
}
