<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\HistorizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: HistorizationRepository::class)]
#[ApiResource]
class Historization
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['historization'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['historization'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['historization'])]
    private ?string $comment = null;

    #[ORM\OneToMany(mappedBy: 'historization', targetEntity: HistorizationFile::class)]
    #[Groups(['historization'])]
    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName', size: 'imageSize')]
    private Collection $files;

    #[ORM\ManyToOne(inversedBy: 'historizations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['historization'])]
    private ?Type $type = null;

    #[ORM\ManyToOne(inversedBy: 'historizations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['historization'])]
    private ?Subtype $subtype = null;

    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection<int, HistorizationFile>
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(HistorizationFile $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files->add($file);
            $file->setHistorization($this);
        }

        return $this;
    }

    public function removeFile(HistorizationFile $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getHistorization() === $this) {
                $file->setHistorization(null);
            }
        }

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

    public function getSubtype(): ?Subtype
    {
        return $this->subtype;
    }

    public function setSubtype(?Subtype $subtype): self
    {
        $this->subtype = $subtype;

        return $this;
    }
}
