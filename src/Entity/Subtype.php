<?php

namespace App\Entity;

use App\Repository\SubtypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SubtypeRepository::class)]
class Subtype
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['types'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['types', 'historization'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'subtypes')]
    private ?Type $type = null;

    #[ORM\OneToMany(mappedBy: 'subtype', targetEntity: Historization::class, orphanRemoval: true)]
    private Collection $historizations;

    public function __construct()
    {
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

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

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
            $historization->setSubtype($this);
        }

        return $this;
    }

    public function removeHistorization(Historization $historization): self
    {
        if ($this->historizations->removeElement($historization)) {
            // set the owning side to null (unless already changed)
            if ($historization->getSubtype() === $this) {
                $historization->setSubtype(null);
            }
        }

        return $this;
    }
}
