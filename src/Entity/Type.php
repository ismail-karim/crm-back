<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['types'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['types', 'historization'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Subtype::class)]
    #[Groups(['types'])]
    private Collection $subtypes;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Historization::class, orphanRemoval: true)]
    private Collection $historizations;

    public function __construct()
    {
        $this->subtypes = new ArrayCollection();
        $this->historizations = new ArrayCollection();
    }

    public function getId(): ?int
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

    /**
     * @return Collection<int, Subtype>
     */
    public function getSubtypes(): Collection
    {
        return $this->subtypes;
    }

    public function addSubtype(Subtype $subtype): self
    {
        if (!$this->subtypes->contains($subtype)) {
            $this->subtypes->add($subtype);
            $subtype->setType($this);
        }

        return $this;
    }

    public function removeSubtype(Subtype $subtype): self
    {
        if ($this->subtypes->removeElement($subtype)) {
            // set the owning side to null (unless already changed)
            if ($subtype->getType() === $this) {
                $subtype->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Historization>
     */
    public function getHistorizations(): Collection
    {
        return $this->historizations;
    }

    public function addHistorization(Historization $historization): self
    {
        if (!$this->historizations->contains($historization)) {
            $this->historizations->add($historization);
            $historization->setType($this);
        }

        return $this;
    }

    public function removeHistorization(Historization $historization): self
    {
        if ($this->historizations->removeElement($historization)) {
            // set the owning side to null (unless already changed)
            if ($historization->getType() === $this) {
                $historization->setType(null);
            }
        }

        return $this;
    }
}
