<?php
declare(strict_types=1);

namespace Pim\CathodeRayTube\CpuState;

use Pim\CathodeRayTube\Instructions;
use Pim\CathodeRayTube\Register;

final readonly class Adding implements Cpu
{
    public function __construct(private Register $register, private Instructions $instructions, private int $toAdd)
    {
    }

    public function tick(): Cpu
    {
        return new Ready($this->register->advance($this->toAdd), $this->instructions);
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