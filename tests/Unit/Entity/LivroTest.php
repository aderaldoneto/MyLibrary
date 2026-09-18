<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Assunto;
use App\Entity\Autor;
use App\Entity\Livro;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

final class LivroTest extends TestCase
{
    public function testDoesNotDuplicateAuthorOrSubjectAssociations(): void
    {
        $livro = new Livro();
        $autor = (new Autor())->setNome('Machado de Assis');
        $assunto = (new Assunto())->setDescricao('Literatura');

        $livro->addAutor($autor)->addAutor($autor);
        $livro->addAssunto($assunto)->addAssunto($assunto);

        self::assertCount(1, $livro->getAutores());
        self::assertCount(1, $livro->getAssuntos());

        $livro->removeAutor($autor)->removeAssunto($assunto);

        self::assertCount(0, $livro->getAutores());
        self::assertCount(0, $livro->getAssuntos());
    }

    public function testValidBookHasNoValidationErrors(): void
    {
        $livro = (new Livro())
            ->setTitulo('Dom Casmurro')
            ->setEditora('Editora Exemplo')
            ->setEdicao(2)
            ->setAnoPublicacao('1899')
            ->setValor(2590)
            ->addAutor((new Autor())->setNome('Machado de Assis'))
            ->addAssunto((new Assunto())->setDescricao('Romance'));

        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        self::assertCount(0, $validator->validate($livro));
    }

    public function testInvalidBookRequiresMandatoryFieldsAndRelations(): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $violations = $validator->validate(new Livro());
        $properties = array_map(
            static fn ($violation): string => $violation->getPropertyPath(),
            iterator_to_array($violations),
        );

        self::assertContains('titulo', $properties);
        self::assertContains('editora', $properties);
        self::assertContains('anoPublicacao', $properties);
        self::assertContains('autores', $properties);
        self::assertContains('assuntos', $properties);
    }
}
