<?php

namespace App\Entity;

use App\Repository\AssuntoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AssuntoRepository::class)]
#[ORM\Table(name: 'assunto')]
class Assunto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'cod_as')]
    private ?int $codigo = null;

    #[ORM\Column(name: 'descricao', length: 20)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 20)]
    private string $descricao = '';

    public function getCodigo(): ?int { 
        return $this->codigo; 
    }

    public function getDescricao(): string { 
        return $this->descricao; 
    }

    public function setDescricao(string $descricao): self { 
        $this->descricao = trim($descricao);
        return $this; 
    }

}
