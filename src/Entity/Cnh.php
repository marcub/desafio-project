<?php

namespace App\Entity;

use App\Repository\CnhRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CnhRepository::class)]
class Cnh
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['motorista'])]
    private ?int $id = null;

    #[Groups(['motorista'])]
    #[ORM\Column(length: 11)]
    private ?string $numero = null;

    #[Groups(['motorista'])]
    #[ORM\Column(length: 2)]
    private ?string $categoria = null;

    #[Groups(['motorista'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $validade = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getCategoria(): ?string
    {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getValidade(): ?\DateTimeInterface
    {
        return $this->validade;
    }

    public function setValidade(\DateTimeInterface $validade): static
    {
        $this->validade = $validade;

        return $this;
    }
}
