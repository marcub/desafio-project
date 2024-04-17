<?php

namespace App\Entity;

use App\Repository\MotoristaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MotoristaRepository::class)]
#[ORM\Table(name: 'motoristas')]
class Motorista
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['motorista'])]
    private ?int $id = null;

    #[Groups(['motorista'])]
    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[Groups(['motorista'])]
    #[ORM\Column(length: 11)]
    private ?string $cpf = null;

    #[Groups(['motorista'])]
    #[ORM\Column(length: 13)]
    private ?string $rg = null;

    #[Groups(['motorista'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dataNascimento = null;

    #[Groups(['motorista'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups(['motorista'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[Groups(['motorista'])]
    #[ORM\OneToOne(targetEntity: Cnh::class, cascade: ["remove", "persist"], fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'cnh_id', referencedColumnName: 'id', nullable: true)]
    private ?Cnh $cnh = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): static
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getRg(): ?string
    {
        return $this->rg;
    }

    public function setRg(string $rg): static
    {
        $this->rg = $rg;

        return $this;
    }

    public function getDataNascimento(): ?\DateTimeInterface
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento(\DateTimeInterface $dataNascimento): static
    {
        $this->dataNascimento = $dataNascimento;

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

    public function getCnh(): ?Cnh
    {
        return $this->cnh;
    }

    public function setCnh(Cnh $cnh): static
    {
        $this->cnh = $cnh;

        return $this;
    }
}
