<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
class Property
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'properties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'property', targetEntity: Bill::class, orphanRemoval: true)]
    private Collection $bills;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'rentedProperties')]
    private Collection $tenants;

    #[ORM\OneToMany(mappedBy: 'property', targetEntity: TenantInvite::class)]
    private Collection $tenantInvites;

    public function __construct()
    {
        $this->bills = new ArrayCollection();
        $this->tenants = new ArrayCollection();
        $this->tenantInvites = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Bill>
     */
    public function getBills(): Collection
    {
        return $this->bills;
    }

    public function addBill(Bill $bill): self
    {
        if (!$this->bills->contains($bill)) {
            $this->bills->add($bill);
            $bill->setProperty($this);
        }

        return $this;
    }

    public function removeBill(Bill $bill): self
    {
        if ($this->bills->removeElement($bill)) {
            // set the owning side to null (unless already changed)
            if ($bill->getProperty() === $this) {
                $bill->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getTenants(): Collection
    {
        return $this->tenants;
    }

    public function addTenant(User $tenant): self
    {
        if (!$this->tenants->contains($tenant)) {
            $this->tenants->add($tenant);
        }

        return $this;
    }

    public function removeTenant(User $tenant): self
    {
        $this->tenants->removeElement($tenant);

        return $this;
    }

    /**
     * @return Collection<int, TenantInvite>
     */
    public function getTenantInvites(): Collection
    {
        return $this->tenantInvites;
    }

    public function addTenantInvite(TenantInvite $tenantInvite): self
    {
        if (!$this->tenantInvites->contains($tenantInvite)) {
            $this->tenantInvites->add($tenantInvite);
            $tenantInvite->setProperty($this);
        }

        return $this;
    }

    public function removeTenantInvite(TenantInvite $tenantInvite): self
    {
        if ($this->tenantInvites->removeElement($tenantInvite)) {
            // set the owning side to null (unless already changed)
            if ($tenantInvite->getProperty() === $this) {
                $tenantInvite->setProperty(null);
            }
        }

        return $this;
    }
}
