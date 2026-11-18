<?php

declare(strict_types=1);

/** Escape HTML per tutto ciò che finisce nella pagina. */
function e(string|int|float|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Prezzo in euro con formato italiano: 1.234,50 €. */
function euro(float $amount): string
{
    return number_format($amount, 2, ',', '.') . ' €';
}
