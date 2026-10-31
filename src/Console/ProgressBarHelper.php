<?php

namespace Esolutions\Laravel\Console;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class ProgressBarHelper
{
    protected OutputInterface $output;

    /**
     * Sin `$output` escribe en la consola. Desde un comando conviene pasar `$this->output`, así lo
     * que imprime la barra queda en la salida del comando (y se ve en `Artisan::output()`).
     */
    public function __construct(protected int $barLength = 20, ?OutputInterface $output = null)
    {
        $this->output = $output ?? new ConsoleOutput();
    }

    public function render(int $processed, int $total, string $status = 'success', ?string $message = null): void
    {
        if ($total === 0) {
            $this->output->writeln('<fg=yellow>No hay elementos a procesar.</>');
            return;
        }

        $percent = $processed / $total;

        // Se cuentan bloques, no bytes: '█' ocupa 3 bytes y strlen() dejaba el vacío en negativo
        // pasada la tercera parte de la barra (str_repeat lanzaba ValueError).
        $blocks       = max(0, min($this->barLength, (int) round($this->barLength * $percent)));
        $filled       = str_repeat('█', $blocks);
        $empty        = str_repeat('░', $this->barLength - $blocks);
        $percentLabel = number_format($percent * 100, 1);

        $color = match ($status) {
            'error'   => 'red',
            'warning' => 'yellow',
            default   => 'white',
            'success' => 'green',
        };

        $line = "<fg={$color}>Progreso: [{$filled}{$empty}] {$processed}/{$total} ({$percentLabel}%)</>";
        if ($message) $line .= " - <fg=white>{$message}</>";

        $this->output->writeln($line);
    }
}
