<?php

namespace App\Tests\Unit\Service;

use App\Entity\Autor;
use App\Exception\CatalogoPersistenceException;
use App\Service\CatalogoPersistenceService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use RuntimeException;

final class CatalogoPersistenceServiceTest extends TestCase
{
    public function testSavesEntityByPersistingAndFlushing(): void
    {
        $entity = (new Autor())->setNome('Carolina Maria de Jesus');
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $entityManager->expects(self::once())->method('persist')->with($entity);
        $entityManager->expects(self::once())->method('flush');
        $logger->expects(self::never())->method('error');

        (new CatalogoPersistenceService($entityManager, $logger))->salvar($entity);
    }

    public function testConvertsUnexpectedPersistenceFailureAndLogsIt(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $logger = $this->createMock(LoggerInterface::class);
        $failure = new RuntimeException('Falha de conexão');

        $entityManager->expects(self::once())->method('persist');
        $entityManager->expects(self::once())->method('flush')->willThrowException($failure);
        $logger->expects(self::once())
            ->method('error')
            ->with('Falha na persistência do catálogo.', self::callback(
                static fn (array $context): bool => 'salvar' === $context['acao'] && $failure === $context['exception'],
            ));

        $service = new CatalogoPersistenceService($entityManager, $logger);

        $this->expectException(CatalogoPersistenceException::class);
        $this->expectExceptionMessage('Não foi possível salvar o registro!');
        $service->salvar(new Autor());
    }
}
