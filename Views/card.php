<?php
/** @var Prodotto $prodotto */
$stelle = $prodotto->stelle();
?>
<article class="product animal-<?= e($prodotto->animale->slug) ?>">
    <div class="product-art" aria-hidden="true">
        <i class="fa-solid <?= e($prodotto->animale->icon) ?>"></i>
    </div>
    <div class="product-body">
        <div class="product-meta">
            <span class="badge-type"><?= e($prodotto->etichetta()) ?></span>
            <span class="badge-animal"><?= e($prodotto->animale->label) ?></span>
        </div>
        <h3><?= e($prodotto->nome) ?></h3>
        <p class="desc"><?= e($prodotto->descrizione) ?></p>
        <?php foreach ($prodotto->dettagli() as $label => $valore): ?>
            <p class="detail"><span><?= e($label) ?>:</span> <?= e($valore) ?></p>
        <?php endforeach; ?>
        <div class="product-foot">
            <span class="rating" title="<?= e(number_format($prodotto->valutazione(), 1, ',', '')) ?> su 5">
                <?= str_repeat('<i class="fa-solid fa-star"></i>', $stelle['piene']) ?>
                <?= str_repeat('<i class="fa-solid fa-star-half-stroke"></i>', $stelle['mezze']) ?>
                <?= str_repeat('<i class="fa-regular fa-star"></i>', $stelle['vuote']) ?>
                <span class="visually-hidden"><?= e(number_format($prodotto->valutazione(), 1, ',', '')) ?> su 5</span>
            </span>
            <strong class="price"><?= e(euro($prodotto->prezzo)) ?></strong>
        </div>
    </div>
</article>
