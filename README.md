# Zampe & Code · negozio per animali in PHP

Esercizio di **programmazione a oggetti in PHP**: un catalogo di accessori, cibo e giochi per cani, gatti, pesci, uccelli e cavalli, con filtri per animale e per reparto.

Progetto di gruppo (Gruppo 3) del corso Full-Stack di [Boolean](https://boolean.careers/), rivisto nel 2026.

## Concetti usati

- **Ereditarietà**: `Accessorio`, `Cibo` e `Gioco` estendono la classe astratta `Prodotto` e aggiungono solo i propri attributi.
- **Trait**: `HasRating` gestisce la valutazione e il calcolo di stelle piene, mezze e vuote.
- **Oggetti valore**: ogni categoria animale è un `AnimalCategory` immutabile (`readonly`).
- **Fabbriche**: `Catalog` legge i file JSON e crea l'oggetto del tipo giusto per ogni reparto.

## Struttura

```
data/         catalogo in JSON (categorie, accessori, cibo, giochi)
src/          classi: Catalog, Models/, Traits/, helpers
views/        template della card prodotto
assets/       foglio di stile e favicon
tests/run.php test minimi senza dipendenze
```

## Come avviarlo

Serve PHP 8.1 o superiore.

```bash
php -S localhost:8000
# poi apri http://localhost:8000
php tests/run.php   # esegue i test
```

## Cosa è cambiato nella revisione del 2026

- Tutto l'output passa da `htmlspecialchars` (prima nessun escape) e i filtri della query string accettano solo valori noti.
- Eliminati `extract()`, gli stili in linea e gli spazi prima di `<?php` che finivano nella pagina.
- La logica ripetuta nelle tre sottoclassi è ora nella classe base; tipi stretti e proprietà `readonly`.
- Sostituite le immagini prese da siti esterni (una non esisteva più, un'altra era la stessa foto di un cane per il cibo dei pesci) con icone per animale.
- Testi segnaposto e "Lorem ipsum" sostituiti da nomi e descrizioni realistici; categorie dei prodotti corrette.
- Nuova interfaccia responsive con filtri, prezzi in formato italiano e mezze stelle.
