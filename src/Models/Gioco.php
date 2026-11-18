<?php

declare(strict_types=1);

require_once __DIR__ . '/Prodotto.php';

final class Gioco extends Prodotto
{
    public function __construct(
        int $id,
        string $nome,
        AnimalCategory $animale,
        float $prezzo,
        float $valutazione,
        string $descrizione,
        public readonly string $tipologia,
    ) {
        parent::__construct($id, $nome, $animale, $prezzo, $valutazione, $descrizione);
    }

    public static function sezione(): string
    {
        return 'Giochi';
    }

    public function etichetta(): string
    {
        return 'Gioco ' . $this->tipologia;
    }
}
