<?php

namespace App\Controller;

use App\Entity\Autor;
use App\Exception\CatalogoPersistenceException;
use App\Exception\RegistroEmUsoException;
use App\Form\AutorType;
use App\Repository\AutorRepository;
use App\Service\CatalogoPersistenceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/autores', name: 'app_autor_')]
final class AutorController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(AutorRepository $autores): Response
    {
        return $this->render('autor/index.html.twig', [
            'autores' => $autores->findAllAlphabetically(),
        ]);
    }

    #[Route('/novo', name: 'novo', methods: ['GET', 'POST'])]
    public function novo(Request $request, CatalogoPersistenceService $persistence): Response
    {
        $autor = new Autor();
        $form = $this->createForm(AutorType::class, $autor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                //TODO: Talvez verificar pra não salvar dois com o nome exatamente iguais
                $persistence->salvar($autor);
                $this->addFlash('success', 'Autor cadastrado com sucesso.');

                return $this->redirectToRoute('app_autor_index');
            } catch (CatalogoPersistenceException $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('autor/novo.html.twig', ['form' => $form]);
    }

    #[Route('/{codigo}/editar', name: 'editar', methods: ['GET', 'POST'], requirements: ['codigo' => '\d+'])]
    public function editar(int $codigo, Request $request, AutorRepository $autores, CatalogoPersistenceService $persistence): Response
    {
        $autor = $this->findAutor($codigo, $autores);
        $form = $this->createForm(AutorType::class, $autor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $persistence->salvar($autor);
                $this->addFlash('success', 'Autor atualizado com sucesso.');

                return $this->redirectToRoute('app_autor_index');
            } catch (CatalogoPersistenceException $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('autor/editar.html.twig', ['autor' => $autor, 'form' => $form]);
    }

    #[Route('/{codigo}', name: 'excluir', methods: ['POST'], requirements: ['codigo' => '\d+'])]
    public function excluir(int $codigo, Request $request, AutorRepository $autores, CatalogoPersistenceService $persistence): Response
    {
        $autor = $this->findAutor($codigo, $autores);

        if (!$this->isCsrfTokenValid('excluir_autor_'.$codigo, (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'A solicitação de exclusão expirou. Tente novamente.');

            return $this->redirectToRoute('app_autor_index');
        }

        try {
            //TODO: eu usaria softdelete, mas como não foi pedido, vou deixar assim mesmo
            $persistence->excluir($autor);
            $this->addFlash('success', 'Autor excluído com sucesso.');
        } catch (RegistroEmUsoException $exception) {
            $this->addFlash('error', 'Este autor está vinculado a livros e não pode ser excluído.');
        } catch (CatalogoPersistenceException $exception) {
            $this->addFlash('error', $exception->getMessage());
        }

        return $this->redirectToRoute('app_autor_index');
    }

    private function findAutor(int $codigo, AutorRepository $autores): Autor
    {
        return $autores->find($codigo) ?? throw $this->createNotFoundException('Autor não encontrado.');
    }
}
