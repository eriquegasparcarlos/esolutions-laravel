<?php

namespace Esolutions\Laravel\Tests\Console;

use Esolutions\Laravel\Console\ProgressBarHelper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * '█' ocupa 3 bytes: la barra medida con strlen() reventaba en str_repeat() pasada la tercera
 * parte (con barLength 30, desde el 12/30 del ejemplo del README).
 */
class ProgressBarHelperTest extends TestCase
{
    private function render(int $processed, int $total, int $length = 30): string
    {
        $output = new BufferedOutput();
        (new ProgressBarHelper($length, $output))->render($processed, $total, 'success', 'fila');

        $text = $output->fetch();
        $this->assertSame(1, preg_match('/\[([█░]*)\] (\d+)\/(\d+) \(([\d.]+)%\) - fila/u', $text, $m), "salida inesperada: {$text}");

        return $m[1];
    }

    public function test_cero_mitad_y_completo(): void
    {
        $this->assertSame(str_repeat('░', 30), $this->render(0, 30));
        $this->assertSame(str_repeat('█', 15) . str_repeat('░', 15), $this->render(15, 30));
        $this->assertSame(str_repeat('█', 30), $this->render(30, 30));
    }

    public function test_ningun_paso_revienta_y_la_barra_mide_siempre_lo_mismo(): void
    {
        foreach ([1, 7, 21, 30, 100] as $total) {
            for ($processed = 0; $processed <= $total; $processed++) {
                $this->assertSame(30, mb_strlen($this->render($processed, $total)), "{$processed}/{$total}");
            }
        }
    }

    public function test_mas_procesados_que_el_total_deja_la_barra_llena(): void
    {
        $this->assertSame(str_repeat('█', 20), $this->render(25, 10, 20));
    }

    public function test_sin_elementos_avisa_en_vez_de_dividir_por_cero(): void
    {
        $output = new BufferedOutput();
        (new ProgressBarHelper(30, $output))->render(0, 0);

        $this->assertStringContainsString('No hay elementos a procesar.', $output->fetch());
    }
}
