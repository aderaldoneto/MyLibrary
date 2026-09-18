<?php

namespace App\Controller;

use App\Entity\Assunto;
use App\Exception\CatalogoPersistenceException;
use App\Exception\RegistroEmUsoException;
use App\Form\AssuntoType;
use App\Repository\AssuntoRepository;
use App\Service\CatalogoPersistenceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/assuntos', name: 'app_assunto_')]
final class AssuntoController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, AssuntoRepository $assuntos): Response
    {
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = 10;
        $total = $assuntos->countAll();
        $totalPages = max(1, (int) ceil($total / $limit));

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        return $this->render('assunto/index.html.twig', [
            'assuntos' => $assuntos->findPage($page, $limit),
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
        ]);
    }

    #[Route('/novo', name: 'novo', methods: ['GET', 'POST'])]
    public function novo(Request $request, CatalogoPersistenceService $persistence): Response
    {
        $assunto = new Assunto();
        $form = $this->createForm(AssuntoType::class, $assunto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $persistence->salvar($assunto);
                $this->addFlash('success', 'Assunto cadastrado com sucesso.');

                return $this->redirectToRoute('app_assunto_index');
            } catch (CatalogoPersistenceException $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('assunto/novo.html.twig', ['form' => $form]);
    }

    #[Route('/{codigo}/editar', name: 'editar', methods: ['GET', 'POST'], requirements: ['codigo' => '\d+'])]
    public function editar(int $codigo, Request $request, AssuntoRepository $assuntos, CatalogoPersistenceService $persistence): Response
    {
        $assunto = $this->findAssunto($codigo, $assuntos);
        $form = $this->createForm(AssuntoType::class, $assunto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $persistence->salvar($assunto);
                $this->addFlash('success', 'Assunto atualizado com sucesso.');

                return $this->redirectToRoute('app_assunto_index');
            } catch (CatalogoPersistenceException $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('assunto/editar.html.twig', ['assunto' => $assunto, 'form' => $form]);
    }

    #[Route('/{codigo}', name: 'excluir', methods: ['POST'], requirements: ['codigo' => '\d+'])]
    public function excluir(int $codigo, Request $request, AssuntoRepository $assuntos, CatalogoPersistenceService $persistence): Response
    {
        $assunto = $this->findAssunto($codigo, $assuntos);

        if (!$this->isCsrfTokenValid('excluir_assunto_'.$codigo, (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'A solicitação de exclusão expirou. Tente novamente.');

            return $this->redirectToRoute('app_assunto_index');
        }

        try {
            $persistence->excluir($assunto);
            $this->addFlash('success', 'Assunto excluído com sucesso.');
        } catch (RegistroEmUsoException $exception) {
            $this->addFlash('error', 'Este assunto está vinculado a livros e não pode ser excluído.');
        } catch (CatalogoPersistenceException $exception) {
            $this->addFlash('error', $exception->getMessage());
        }

        return $this->redirectToRoute('app_assunto_index');
    }

    private function findAssunto(int $codigo, AssuntoRepository $assuntos): Assunto
    {
        return $assuntos->find($codigo) ?? throw $this->createNotFoundException('Assunto não encontrado.');
    }
}
