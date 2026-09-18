<?php

namespace App\Tests\Unit\Form\DataTransformer;

use App\Form\DataTransformer\CentavosParaMoedaTransformer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Exception\TransformationFailedException;

final class CentavosParaMoedaTransformerTest extends TestCase
{
    #[DataProvider('formattedValues')]
    public function testTransformsCentsToBrazilianCurrency(int $centavos, string $expected): void
    {
        self::assertSame($expected, (new CentavosParaMoedaTransformer())->transform($centavos));
    }

    /** @return iterable<string, array{int, string}> */
    public static function formattedValues(): iterable
    {
        yield 'zero' => [0, '0,00'];
        yield 'whole amount' => [2500, '25,00'];
        yield 'thousand separator' => [123456, '1.234,56'];
    }

    #[DataProvider('inputValues')]
    public function testTransformsBrazilianCurrencyToCents(string $input, int $expected): void
    {
        self::assertSame($expected, (new CentavosParaMoedaTransformer())->reverseTransform($input));
    }

    /** @return iterable<string, array{string, int}> */
    public static function inputValues(): iterable
    {
        yield 'empty field' => ['', 0];
        yield 'digits typed by the mask' => ['2590', 2590];
        yield 'Brazilian decimal value' => ['25,90', 2590];
        yield 'currency with separator' => ['R$ 1.234,56', 123456];
    }

    public function testRejectsInvalidCurrencyValues(): void
    {
        $transformer = new CentavosParaMoedaTransformer();

        $this->expectException(TransformationFailedException::class);
        $transformer->reverseTransform('vinte reais');
    }
}
