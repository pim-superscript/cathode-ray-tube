<?php
declare(strict_types=1);

namespace Pim\CathodeRayTube\CpuState;

interface Cpu
{
    public function tick(): Cpu;

    public function registerX(): int;

    public function signalStrength(): int;
}