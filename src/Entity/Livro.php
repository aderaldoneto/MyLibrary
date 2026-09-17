<?php

namespace App\Entity;

use App\Repository\LivroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LivroRepository::class)]
#[ORM\Table(name: 'livro')]
class Livro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'cod_l')]
    private ?int $codigo = null;

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    private string $titulo = '';

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    private string $editora = '';

    #[ORM\Column]
    #[Assert\Positive]
    private int $edicao = 1;

    #[ORM\Column(name: 'ano_publicacao', length: 4)]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^\d{4}$/', message: 'O ano de publicação deve ter quatro dígitos.')]
    private string $anoPublicacao = '';

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private int $valor = 0;

    /** @var Collection<int, Autor> */
    #[ORM\ManyToMany(targetEntity: Autor::class)]
    #[ORM\JoinTable(name: 'livro_autor')]
    #[ORM\JoinColumn(name: 'livro_cod_l', referencedColumnName: 'cod_l', nullable: false, onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'autor_cod_au', referencedColumnName: 'cod_au', nullable: false, onDelete: 'RESTRICT')]
    private Collection $autores;

    /** @var Collection<int, Assunto> */
    #[ORM\ManyToMany(targetEntity: Assunto::class)]
    #[ORM\JoinTable(name: 'livro_assunto')]
    #[ORM\JoinColumn(name: 'livro_cod_l', referencedColumnName: 'cod_l', nullable: false, onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'assunto_cod_as', referencedColumnName: 'cod_as', nullable: false, onDelete: 'RESTRICT')]
    private Collection $assuntos;

    public function __construct()
    {
        $this->autores = new ArrayCollection();
        $this->assuntos = new ArrayCollection();
    }

    public function getCodigo(): ?int { 
        return $this->codigo; 
    }

    public function getTitulo(): string { 
        return $this->titulo; 
    }

    public function setTitulo(string $titulo): self { 
        $this->titulo = trim($titulo);
        return $this; 
    }

    public function getEditora(): string { 
        return $this->editora; 
    }

    public function setEditora(string $editora): self { 
        $this->editora = trim($editora);
        return $this; 
    }

    public function getEdicao(): int { 
        return $this->edicao; 
    }

    public function setEdicao(int $edicao): self { 
        $this->edicao = $edicao; 
        return $this; 
    }

    public function getAnoPublicacao(): string { 
        return $this->anoPublicacao; 
    }

    public function setAnoPublicacao(string $anoPublicacao): self { 
        $this->anoPublicacao = trim($anoPublicacao);
        return $this; 
    }

    public function getValor(): int { 
        return $this->valor; 
    }

    public function setValor(int $valor): self { 
        $this->valor = $valor; 
        return $this; 
    }

    /** @return Collection<int, Autor> */
    public function getAutores(): Collection { 
        return $this->autores; 
    }

    public function addAutor(Autor $autor): self { 
        if (!$this->autores->contains($autor)) { 
            $this->autores->add($autor); 
        } 
        return $this; 
    }

    public function removeAutor(Autor $autor): self { 
        $this->autores->removeElement($autor); 
        return $this; 
    }

    /** @return Collection<int, Assunto> */
    public function getAssuntos(): Collection { 
        return $this->assuntos; 
    }

    public function addAssunto(Assunto $assunto): self { 
        if (!$this->assuntos->contains($assunto)) { 
            $this->assuntos->add($assunto); 
        } 
        return $this; 
    }

    public function removeAssunto(Assunto $assunto): self { 
        $this->assuntos->removeElement($assunto); 
        return $this; 
    }
    
}
