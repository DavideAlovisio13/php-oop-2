<?php

declare(strict_types=1);

/** Categoria animale: nome, etichetta e icona Font Awesome. Oggetto immutabile. */
final class AnimalCategory
{
    public function __construct(
        public readonly string $slug,
        public readonly string $label,
        public readonly string $icon,
    ) {
    }
}
