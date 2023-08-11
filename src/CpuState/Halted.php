<?php
declare(strict_types=1);

namespace Pim\CathodeRayTube\CpuState;

use LogicException;
use Pim\CathodeRayTube\Register;

final readonly class Halted implements Cpu
{
    public function __construct(private Register $register)
    {
    }

    public function tick(): Cpu
    {
        throw new LogicException('cpu has halted');
    }

    public function registerX(): int
    {
        return $this->register->x();
    }

    public function signalStrength(): int
    {
        return $this->register->signalStrength();
    }
}