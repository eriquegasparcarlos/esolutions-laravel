<?php

namespace Esolutions\Laravel\Console;

use Symfony\Component\Console\Output\ConsoleOutput;

class ProgressBarHelper
{
    protected ConsoleOutput $output;

    public function __construct(protected int $barLength = 20)
    {
        $this->output = new ConsoleOutput();
    }

    public function render(int $processed, int $total, string $status = 'success', ?string $message = null): void
    {
        if ($total === 0) {
            $this->output->writeln('<fg=yellow>No hay elementos a procesar.</>');
            return;
        }

        $percent      = $processed / $total;
        $filled       = str_repeat('█', (int) round($this->barLength * $percent));
        $empty        = str_repeat('░', $this->barLength - strlen($filled));
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
