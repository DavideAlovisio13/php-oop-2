<?php

declare(strict_types=1);

require_once __DIR__ . '/Models/Accessorio.php';
require_once __DIR__ . '/Models/Cibo.php';
require_once __DIR__ . '/Models/Gioco.php';

/**
 * Carica il catalogo dai file JSON e crea gli oggetti del tipo giusto.
 * Ogni sezione ha una "fabbrica" che sa leggere i propri campi.
 */
final class Catalog
{
    /** @var array<string, AnimalCategory> */
    private array $animali = [];

    /** @var array<string, list<Prodotto>> */
    private array $sezioni = [];

    public function __construct(private readonly string $dataDir)
    {
        $categorie = $this->readJson('categorie.json');
        foreach ($categorie['animali'] as $slug => $info) {
            $this->animali[$slug] = new AnimalCategory($slug, $info['label'], $info['icon']);
        }

        $factories = [
            'accessori.json' => fn (array $r, AnimalCategory $a): Prodotto => new Accessorio(
                $r['id'], $r['nome'], $a, (float) $r['prezzo'], (float) $r['valutazione'], $r['descrizione'], $r['tipo']
            ),
            'giochi.json' => fn (array $r, AnimalCategory $a): Prodotto => new Gioco(
                $r['id'], $r['nome'], $a, (float) $r['prezzo'], (float) $r['valutazione'], $r['descrizione'], $r['tipologia']
            ),
            'cibo.json' => fn (array $r, AnimalCategory $a): Prodotto => new Cibo(
                $r['id'], $r['nome'], $a, (float) $r['prezzo'], (float) $r['valutazione'], $r['descrizione'], $r['tipologia'], $r['peso']
            ),
        ];

        foreach ($factories as $file => $make) {
            foreach ($this->readJson($file) as $row) {
                $animale = $this->animali[$row['animale']]
                    ?? throw new UnexpectedValueException("Animale sconosciuto '{$row['animale']}' in {$file}");
                $prodotto = $make($row, $animale);
                $this->sezioni[$prodotto::sezione()][] = $prodotto;
            }
        }
    }

    /** @return array<string, AnimalCategory> */
    public function animali(): array
    {
        return $this->animali;
    }

    /** @return list<string> */
    public function nomiSezioni(): array
    {
        return array_keys($this->sezioni);
    }

    /**
     * Prodotti raggruppati per sezione, filtrati per animale e/o sezione (null = tutti).
     *
     * @return array<string, list<Prodotto>>
     */
    public function filtra(?string $animale = null, ?string $sezione = null): array
    {
        $risultato = [];
        foreach ($this->sezioni as $nome => $prodotti) {
            if ($sezione !== null && $nome !== $sezione) {
                continue;
            }
            $trovati = array_values(array_filter(
                $prodotti,
                fn (Prodotto $p): bool => $animale === null || $p->animale->slug === $animale,
            ));
            if ($trovati !== []) {
                $risultato[$nome] = $trovati;
            }
        }

        return $risultato;
    }

    private function readJson(string $file): array
    {
        $path = $this->dataDir . '/' . $file;
        $data = json_decode((string) file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);
        if (!is_array($data)) {
            throw new UnexpectedValueException("Formato non valido: {$file}");
        }

        return $data;
    }
}
