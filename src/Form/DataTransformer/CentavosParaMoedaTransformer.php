<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/** @implements DataTransformerInterface<int, string> */
final class CentavosParaMoedaTransformer implements DataTransformerInterface
{
    public function transform(mixed $value): string
    {
        if (null === $value) {
            return '';
        }

        if (!is_int($value) || $value < 0) {
            throw new TransformationFailedException('Valor inválido!');
        }

        return number_format($value / 100, 2, ',', '.');
    }

    public function reverseTransform(mixed $value): int
    {
        if (!is_string($value)) {
            throw new TransformationFailedException('Informe um valor válido!');
        }

        $value = trim($value);
        if ('' === $value) {
            return 0;
        }

        if (!preg_match('/^[0-9.,\sR$]+$/u', $value)) {
            throw new TransformationFailedException('Informe um valor válido!');
        }

        if (!str_contains($value, ',')) {
            return (int) preg_replace('/\D/', '', $value);
        }

        [$inteiros, $centavos] = explode(',', $value, 2);
        $inteiros = preg_replace('/\D/', '', $inteiros);
        $centavos = preg_replace('/\D/', '', $centavos);

        return ((int) $inteiros * 100) + (int) str_pad(substr($centavos, 0, 2), 2, '0');
    }
}
