<?php

declare(strict_types=1);

// Test minimi senza dipendenze: php tests/run.php

require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/Catalog.php';

$failures = 0;
function check(string $name, bool $ok): void
{
    global $failures;
    echo ($ok ? 'OK   ' : 'FAIL ') . $name . PHP_EOL;
    $failures += $ok ? 0 : 1;
}

$catalog = new Catalog(__DIR__ . '/../data');
$tutti = $catalog->filtra();
check('tre sezioni', array_keys($tutti) === ['Accessori', 'Giochi', 'Cibo']);
check('30 prodotti in totale', array_sum(array_map('count', $tutti)) === 30);
check('filtro per animale', array_reduce($catalog->filtra('cane'), fn ($ok, $l) => $ok && array_reduce($l, fn ($o, $p) => $o && $p->animale->slug === 'cane', true), true));
check('filtro per sezione', array_keys($catalog->filtra(null, 'Cibo')) === ['Cibo']);
check('sottoclassi corrette', $tutti['Cibo'][0] instanceof Cibo && $tutti['Giochi'][0] instanceof Gioco && $tutti['Accessori'][0] instanceof Accessorio);
check('dettagli specifici del cibo', isset($tutti['Cibo'][0]->dettagli()['Confezione']));

$cane = new AnimalCategory('cane', 'Cane', 'fa-dog');
$g = new Gioco(99, 'Test', $cane, 1.0, 4.3, 'x', 'test');
check('4,3 -> 4 piene + 1 mezza (arrotondamento alla mezza stella)', $g->stelle() === ['piene' => 4, 'mezze' => 1, 'vuote' => 0]);
$g3 = new Gioco(96, 'Test', $cane, 1.0, 4.2, 'x', 'test');
check('4,2 -> 4 piene + 1 vuota', $g3->stelle() === ['piene' => 4, 'mezze' => 0, 'vuote' => 1]);
$g2 = new Gioco(98, 'Test', $cane, 1.0, 4.6, 'x', 'test');
check('4,6 -> 4 piene + 1 mezza', $g2->stelle() === ['piene' => 4, 'mezze' => 1, 'vuote' => 0]);
check('escape HTML', e('<b>"x"</b>') === '&lt;b&gt;&quot;x&quot;&lt;/b&gt;');
check('prezzo in euro', euro(1234.5) === '1.234,50 €');

try {
    new Gioco(97, 'Test', $cane, -1.0, 3, 'x', 'test');
    check('prezzo negativo rifiutato', false);
} catch (InvalidArgumentException) {
    check('prezzo negativo rifiutato', true);
}

exit($failures === 0 ? 0 : 1);
