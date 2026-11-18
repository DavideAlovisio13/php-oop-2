<?php

declare(strict_types=1);

require_once __DIR__ . '/../Traits/HasRating.php';
require_once __DIR__ . '/AnimalCategory.php';

/**
 * Prodotto generico del negozio. Le sottoclassi aggiungono i propri attributi
 * e descrivono il proprio tipo; la logica comune (prezzo, animale, valutazione) sta qui.
 */
abstract class Prodotto
{
    use HasRating;

    public function __construct(
        public readonly int $id,
        public readonly string $nome,
        public readonly AnimalCategory $animale,
        public readonly float $prezzo,
        float $valutazione,
        public readonly string $descrizione,
    ) {
        if ($prezzo < 0) {
            throw new InvalidArgumentException("Prezzo negativo per il prodotto {$id}");
        }
        $this->valutazione = $valutazione;
    }

    /** Nome della sezione (es. "Accessori"). */
    abstract public static function sezione(): string;

    /** Etichetta breve del tipo di prodotto, mostrata come badge. */
    abstract public function etichetta(): string;

    /** Dettagli specifici della sottoclasse, come coppie etichetta => valore. */
    public function dettagli(): array
    {
        return [];
    }
}
