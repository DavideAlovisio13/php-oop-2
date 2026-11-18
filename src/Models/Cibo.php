<?php

declare(strict_types=1);

require_once __DIR__ . '/Prodotto.php';

final class Cibo extends Prodotto
{
    public function __construct(
        int $id,
        string $nome,
        AnimalCategory $animale,
        float $prezzo,
        float $valutazione,
        string $descrizione,
        public readonly string $tipologia,
        public readonly string $peso,
    ) {
        parent::__construct($id, $nome, $animale, $prezzo, $valutazione, $descrizione);
    }

    public static function sezione(): string
    {
        return 'Cibo';
    }

    public function etichetta(): string
    {
        return 'Cibo ' . $this->tipologia;
    }

    public function dettagli(): array
    {
        return ['Confezione' => $this->peso];
    }
}
