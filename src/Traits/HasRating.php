<?php

declare(strict_types=1);

/** Valutazione da 0 a 5 con supporto alle mezze stelle. */
trait HasRating
{
    protected float $valutazione = 0.0;

    public function valutazione(): float
    {
        return $this->valutazione;
    }

    /** Stelle piene, mezze e vuote, arrotondate alla mezza stella più vicina. */
    public function stelle(): array
    {
        $halfSteps = (int) round(max(0, min(5, $this->valutazione)) * 2);
        $full = intdiv($halfSteps, 2);
        $half = $halfSteps % 2;

        return ['piene' => $full, 'mezze' => $half, 'vuote' => 5 - $full - $half];
    }
}
