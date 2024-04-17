<?php

namespace App\Entity;

use App\Repository\VeiculoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VeiculoRepository::class)]
class Veiculo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['veiculo'])]
    private ?int $id = null;

    #[ORM\Column(length: 11)]
    #[Groups(['veiculo'])]
    private ?string $crlv = null;

    #[ORM\Column(length: 255)]
    #[Groups(['veiculo'])]
    private ?string $nomeDoProprietario = null;

    #[ORM\Column(length: 255)]
    #[Groups(['veiculo'])]
    private ?string $tipo = null;

    #[ORM\Column]
    #[Groups(['veiculo'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['veiculo'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(targetEntity: Motorista::class)]
    #[ORM\JoinColumn(name: 'motorista_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['veiculo'])]
    private ?Motorista $motorista = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCrlv(): ?string
    {
        return $this->crlv;
    }

    public function setCrlv(string $crlv): static
    {
        $this->crlv = $crlv;

        return $this;
    }

    public function getNomeDoProprietario(): ?string
    {
        return $this->nomeDoProprietario;
    }

    public function setNomeDoProprietario(string $nomeDoProprietario): static
    {
        $this->nomeDoProprietario = $nomeDoProprietario;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getMotorista(): ?Motorista
    {
        return $this->motorista;
    }

    public function setMotorista(?Motorista $motorista): static
    {

        $this->motorista = $motorista;

        return $this;
    }
}
