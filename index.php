<?php

declare(strict_types=1);

require_once __DIR__ . '/src/helpers.php';
require_once __DIR__ . '/src/Catalog.php';

$catalog = new Catalog(__DIR__ . '/data');
$animali = $catalog->animali();
$sezioni = $catalog->nomiSezioni();

// Filtri dalla query string, accettati solo se presenti nelle liste note
$animale = $_GET['animale'] ?? null;
$animale = is_string($animale) && isset($animali[$animale]) ? $animale : null;
$sezione = $_GET['sezione'] ?? null;
$sezione = is_string($sezione) && in_array($sezione, $sezioni, true) ? $sezione : null;

$risultati = $catalog->filtra($animale, $sezione);
$totale = array_sum(array_map('count', $risultati));

/** Link che mantiene un filtro e cambia l'altro. */
function filterUrl(?string $animale, ?string $sezione): string
{
    $query = http_build_query(array_filter(['animale' => $animale, 'sezione' => $sezione]));

    return $query === '' ? '?' : '?' . $query;
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Negozio di prodotti per animali: esercizio di programmazione a oggetti in PHP.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="icon" href="assets/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="assets/style.css">
    <title>Zampe &amp; Code · Negozio per animali</title>
</head>

<body>
    <header class="hero">
        <div class="container">
            <p class="eyebrow"><i class="fa-solid fa-paw"></i> Esercizio PHP · programmazione a oggetti</p>
            <h1>Zampe &amp; Code</h1>
            <p class="lead">Accessori, cibo e giochi per cani, gatti, pesci, uccelli e cavalli. Ogni prodotto è un oggetto
                PHP che estende una classe comune e condivide la logica delle valutazioni tramite un trait.</p>
        </div>
    </header>

    <main class="container">
        <nav class="filters" aria-label="Filtri">
            <div class="filter-group">
                <span class="filter-label">Animale</span>
                <a class="chip <?= $animale === null ? 'active' : '' ?>" href="<?= e(filterUrl(null, $sezione)) ?>">Tutti</a>
                <?php foreach ($animali as $slug => $cat): ?>
                    <a class="chip <?= $animale === $slug ? 'active' : '' ?>" href="<?= e(filterUrl($slug, $sezione)) ?>">
                        <i class="fa-solid <?= e($cat->icon) ?>"></i> <?= e($cat->label) ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="filter-group">
                <span class="filter-label">Reparto</span>
                <a class="chip <?= $sezione === null ? 'active' : '' ?>" href="<?= e(filterUrl($animale, null)) ?>">Tutti</a>
                <?php foreach ($sezioni as $nome): ?>
                    <a class="chip <?= $sezione === $nome ? 'active' : '' ?>" href="<?= e(filterUrl($animale, $nome)) ?>"><?= e($nome) ?></a>
                <?php endforeach; ?>
            </div>
        </nav>

        <p class="count"><?= e($totale) ?> prodotti</p>

        <?php foreach ($risultati as $nome => $prodotti): ?>
            <section class="section">
                <h2><?= e($nome) ?> <span><?= e(count($prodotti)) ?></span></h2>
                <div class="grid">
                    <?php foreach ($prodotti as $prodotto) {
                        include __DIR__ . '/views/card.php';
                    } ?>
                </div>
            </section>
        <?php endforeach; ?>
    </main>

    <footer class="footer">
        Progetto di gruppo (Gruppo 3) del corso Full-Stack di Boolean · rivisto nel 2026
    </footer>
</body>

</html>
