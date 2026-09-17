<?php

namespace App\Controller;

use App\Repository\RelatorioAcervoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/relatorios', name: 'app_relatorio_')]
final class RelatorioController extends AbstractController
{
    #[Route('/acervo-por-autor', name: 'acervo_por_autor', methods: ['GET'])]
    public function acervoPorAutor(RelatorioAcervoRepository $relatorio): Response
    {
        return $this->render('relatorio/acervo_por_autor.html.twig', [
            'autores' => $this->groupByAuthor($relatorio->findAllGroupedByAuthor()),
        ]);
    }

    /** @param list<array<string, mixed>> $linhas
     *  @return list<array{codigo: string, nome: string, livros: list<array<string, mixed>>}>
     */
    private function groupByAuthor(array $linhas): array
    {
        $autores = [];

        foreach ($linhas as $linha) {
            $codigo = (string) $linha['autor_codigo'];
            if (!isset($autores[$codigo])) {
                $autores[$codigo] = ['codigo' => $codigo, 'nome' => (string) $linha['autor_nome'], 'livros' => []];
            }

            $autores[$codigo]['livros'][] = $linha;
        }

        return array_values($autores);
    }
}
