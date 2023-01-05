<?php

namespace App\Entity;

use App\Enum\BillTypeEnum;
use App\Form\BillType;
use App\Repository\BillRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: BillRepository::class)]
class Bill
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'bills')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Property $property = null;

    #[ORM\Column]
    private ?int $priceTotal = null;

    #[ORM\Column]
    private ?int $splitOn = null;

    #[ORM\Column(length: 255)]
    private ?BillTypeEnum $type = null;

    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $paidBy;

    #[ORM\Column]
    private ?bool $archived = false;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->paidBy = new ArrayCollection();
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

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getPriceTotal(): ?float
    {
        return $this->priceTotal / 100;
    }

    public function setPriceTotal(float $priceTotal): self
    {
        $this->priceTotal = $priceTotal * 100;

        return $this;
    }

    public function getSplitOn(): ?int
    {
        return $this->splitOn;
    }

    public function setSplitOn(int $splitOn): self
    {
        $this->splitOn = $splitOn;

        return $this;
    }

    public function getType(): ?BillTypeEnum
    {
        return $this->type;
    }

    public function setType(BillTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPaidBy(): Collection
    {
        return $this->paidBy;
    }

    public function addPaidBy(User $paidBy): self
    {
        if (!$this->paidBy->contains($paidBy)) {
            $this->paidBy->add($paidBy);
        }

        return $this;
    }

    public function removePaidBy(User $paidBy): self
    {
        $this->paidBy->removeElement($paidBy);

        return $this;
    }

    public function isArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }
}
