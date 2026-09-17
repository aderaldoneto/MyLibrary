<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'autor')]
class Autor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'cod_au')]
    private ?int $codigo = null;

    #[ORM\Column(name: 'nome', length: 40)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    private string $nome = '';

    public function getCodigo(): ?int { 
        return $this->codigo; 
    }

    public function getNome(): string { 
        return $this->nome; 
    }

    public function setNome(string $nome): self { 
        $this->nome = $nome; 
        return $this; 
    }

}
