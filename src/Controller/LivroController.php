<?php

namespace App\Controller;

use App\Entity\Livro;
use App\Exception\CatalogoPersistenceException;
use App\Form\LivroType;
use App\Repository\LivroRepository;
use App\Service\CatalogoPersistenceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/livros', name: 'app_livro_')]
final class LivroController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, LivroRepository $livros): Response
    {
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = 10;
        $total = $livros->countAll();
        $totalPages = max(1, (int) ceil($total / $limit));

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        return $this->render('livro/index.html.twig', [
            'livros' => $livros->findPage($page, $limit),
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
        ]);
    }

    #[Route('/novo', name: 'novo', methods: ['GET', 'POST'])]
    public function novo(Request $request, CatalogoPersistenceService $persistence): Response
    {
        $livro = new Livro();
        $form = $this->createForm(LivroType::class, $livro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $persistence->salvar($livro);
                $this->addFlash('success', 'Livro cadastrado com sucesso.');
                return $this->redirectToRoute('app_livro_index');
            } catch (CatalogoPersistenceException $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('livro/novo.html.twig', ['form' => $form]);
    }

    #[Route('/{codigo}/editar', name: 'editar', methods: ['GET', 'POST'], requirements: ['codigo' => '\d+'])]
    public function editar(int $codigo, Request $request, LivroRepository $livros, CatalogoPersistenceService $persistence): Response
    {
        $livro = $this->findLivro($codigo, $livros);
        $form = $this->createForm(LivroType::class, $livro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $persistence->salvar($livro);
                $this->addFlash('success', 'Livro atualizado com sucesso.');
                return $this->redirectToRoute('app_livro_index');
            } catch (CatalogoPersistenceException $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('livro/editar.html.twig', ['livro' => $livro, 'form' => $form]);
    }

    #[Route('/{codigo}', name: 'exibir', methods: ['GET'], requirements: ['codigo' => '\d+'])]
    public function exibir(int $codigo, LivroRepository $livros): Response
    {
        return $this->render('livro/exibir.html.twig', ['livro' => $this->findLivro($codigo, $livros)]);
    }

    #[Route('/{codigo}', name: 'excluir', methods: ['POST'], requirements: ['codigo' => '\d+'])]
    public function excluir(int $codigo, Request $request, LivroRepository $livros, CatalogoPersistenceService $persistence): Response
    {
        $livro = $this->findLivro($codigo, $livros);
        if (!$this->isCsrfTokenValid('excluir_livro_'.$codigo, (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'A solicitação de exclusão expirou. Tente novamente.');
            return $this->redirectToRoute('app_livro_index');
        }

        try {
            $persistence->excluir($livro);
            $this->addFlash('success', 'Livro excluído com sucesso.');
        } catch (CatalogoPersistenceException $exception) {
            $this->addFlash('error', $exception->getMessage());
        }

        return $this->redirectToRoute('app_livro_index');
    }

    private function findLivro(int $codigo, LivroRepository $livros): Livro
    {
        return $livros->findOneForDetail($codigo) ?? throw $this->createNotFoundException('Livro não encontrado.');
    }
}
