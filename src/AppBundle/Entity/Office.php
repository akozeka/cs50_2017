<?php

namespace AppBundle\Entity;

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
 *     }
 * )
 * @UniqueEntity(fields="slug")
 */
class Office
{
    use EntityIdentityTrait;
    use EntityCrudTrait;
    use EntityPostAddressTrait;

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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
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
