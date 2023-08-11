<?php
declare(strict_types=1);

namespace Pim\CathodeRayTube;

use Pim\CathodeRayTube\CpuState\Cpu;
use Pim\CathodeRayTube\CpuState\Halted;

final class Cursor
{
    private int $currentCycle = 1;

    public function __construct(private Cpu $cpu)
    {
    }

    public function runTo(int $cycle): Cpu
    {
        for(; $this->currentCycle < $cycle; $this->currentCycle++) {
            $this->cpu = $this->cpu->tick();
        }
        return $this->cpu;
    }

    public function execute(): Cpu
    {
        while (!$this->cpu instanceof Halted) {
            $this->cpu = $this->cpu->tick();
        }
        return $this->cpu;
    }
}