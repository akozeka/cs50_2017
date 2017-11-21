<?php

namespace AppBundle\Entity;

use AppBundle\Utils\Geo\AddressInterface;
use AppBundle\Utils\Geo\GeoPointInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="office",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="UNIQ_office_slug", columns="slug")
 *     },
 *     indexes={
 *         @ORM\Index(name="IDX_office_name", columns="name")
 *     }
 * )
 * @UniqueEntity(fields="slug")
 */
class Office implements AddressInterface, GeoPointInterface, \JsonSerializable
{
    use EntityIdentityTrait;
    use EntityCrudTrait;
    use EntityPostAddressTrait;
    use EntityGeoPointTrait;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name", "postAddress.zipCode"})
     * @ORM\Column(type="string")
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var User[]|Collection|iterable
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="office")
     * @ORM\OrderBy({"lastName": "ASC", "firstName": "ASC"})
     */
    private $users;

    /**
     * @var OfficeCategory[]|Collection|iterable
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\OfficeCategory", inversedBy="offices")
     */
    private $categories;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'fullName' => $this->getFullName(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
        ];
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getFullName()
    {
        return "$this->name ({$this->getCountry()}, {$this->getCity()}, {$this->getZipCode()})";
    }

    public function addCategory(OfficeCategory $category): void
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }
    }

    public function removeCategory(OfficeCategory $category): void
    {
        $this->categories->removeElement($category);
    }
}
