<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Property::class)]
    private Collection $properties;

    #[ORM\ManyToOne]
    private ?Property $currentProperty = null;

    #[ORM\ManyToMany(targetEntity: Property::class, mappedBy: 'tenants')]
    private Collection $rentedProperties;

    #[ORM\OneToMany(mappedBy: 'tenant', targetEntity: TenantInvite::class)]
    private Collection $tenantInvites;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
        $this->rentedProperties = new ArrayCollection();
        $this->tenantInvites = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Property>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties->add($property);
            $property->setOwner($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getOwner() === $this) {
                $property->setOwner(null);
            }
        }

        return $this;
    }

    public function getCurrentProperty(): ?Property
    {
        return $this->currentProperty;
    }

    public function setCurrentProperty(?Property $currentProperty): self
    {
        $this->currentProperty = $currentProperty;

        return $this;
    }

    /**
     * @return Collection<int, Property>
     */
    public function getRentedProperties(): Collection
    {
        return $this->rentedProperties;
    }

    public function addRentedProperty(Property $rentedProperty): self
    {
        if (!$this->rentedProperties->contains($rentedProperty)) {
            $this->rentedProperties->add($rentedProperty);
            $rentedProperty->addTenant($this);
        }

        return $this;
    }

    public function removeRentedProperty(Property $rentedProperty): self
    {
        if ($this->rentedProperties->removeElement($rentedProperty)) {
            $rentedProperty->removeTenant($this);
        }

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
            $tenantInvite->setTenant($this);
        }

        return $this;
    }

    public function removeTenantInvite(TenantInvite $tenantInvite): self
    {
        if ($this->tenantInvites->removeElement($tenantInvite)) {
            // set the owning side to null (unless already changed)
            if ($tenantInvite->getTenant() === $this) {
                $tenantInvite->setTenant(null);
            }
        }

        return $this;
    }
}
