<?php

namespace App\Entity;

use App\Repository\HistorizationFileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistorizationFileRepository::class)]
class HistorizationFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\ManyToOne(inversedBy: 'files')]
    private ?Historization $historization = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getHistorization(): ?Historization
    {
        return $this->historization;
    }

    public function setHistorization(?Historization $historization): self
    {
        $this->historization = $historization;

        return $this;
    }
}
